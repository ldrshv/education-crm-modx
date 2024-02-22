<?php
namespace App\Controllers;
use Zoomx\Controllers;

class Auth extends \Zoomx\Controllers\Controller
{
    /**
     * 
     */
    public function is_auth()
    {
        return jsonx(['success' => $this->modx->user->isAuthenticated('web')]);
    }


    /**
     * 
     */
    public function login()
    {
        $response = $this->modx->runProcessor('/security/login', [
            'username' => trim($_POST['username'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'rememberme' => 1,
            'login_context' => $this->modx->context->key ?? 'web',
        ]);
        
        return jsonx([
            'success' => !$response->isError(),
            'message' => $response->getMessage() ?? '',
        ]);
    }


    /**
     * 
     */
    public function logout()
    {
        $this->modx->runProcessor('/security/logout');
        return jsonx([
            'success' => true
        ]);
    }


    /**
     * @todo распарсить ошибки
     */
    public function register()
    {
        $email = trim($_POST['email'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return jsonx([
                'success' => false,
                'errors' => ['email' => 'Введите корректный email'],
            ]);
        }

        $data = [
            "active" => 0,
            'username' => $email,
            'email' => $email,
            'phone' => trim($_POST['phone'] ?? ''),
            'specifiedpassword' => trim($_POST['specifiedpassword'] ?? ''),
            'confirmpassword' => trim($_POST['confirmpassword'] ?? ''),
            'newpassword' => 'passwordgenmethod',
            'passwordgenmethod' => false,
            'passwordnotifymethod'  => 's',
        ];

        $this->modx->user = $this->modx->getObject('modUser', 1); // админские права
        $response = $this->modx->runProcessor('security/user/create', $data);

        if ($response->isError()) {
            $errors_tmp = $response->getAllErrors() ?: [];
            $errors = [];
            foreach ($errors_tmp as $i) {
                $tmp = explode(': ', $i);
                $errors[$tmp[0] === 'username' ? 'email' : $tmp[0]] = $tmp[1];
            }

            return jsonx([
                'success' => !$response->isError(),
                'message' => $response->getMessage() ?? '',
                'errors' => $errors,
            ]);
        }

        $user = $this->modx->getObject('modUser', ['username' => $email]);
        $confirm_key = md5($user->username . ':' .$user->password);
        $confirm_url = $this->modx->getOption('site_url') . "api/auth/confirm-register?user={$user->username}&key={$confirm_key}";

        $email_params = [
            'subject' => 'Подтверждение регистрации',
            'content' => parserx()->parse(file_get_contents(MODX_CORE_PATH . 'app/templates/emails/register.tpl'), [
                'title' => 'Подтверждение регистрации',
                'confirm_url' => $confirm_url,
                'email' => $email,
            ]),
        ];
        email($email, $email_params);

        return jsonx([
            'success' => !$response->isError(),
            'message' => 'Спасибо за регистрацию на сайте! Далее вам нужно подтвердить свой email. Ссылка для подтверждения выслана на указанный вами email. Если письмо не пришло, проверьте папку «Спам»',
        ]);
    }


    /**
     * 
     */
    public function confirm_register()
    {
        if (empty($_GET['key']) || empty($_GET['user'])) {
            return redirectx('/#/auth/error?error=activate-link&code=1');
        }

        $user = $this->modx->getObject('modUser', ['username' => $_GET['user']]);
        if (!$user) {
            return redirectx('/#/auth/error?error=activate-link&code=2');
        }

        $confirm_key = md5($user->username . ':' .$user->password);
        if ($confirm_key !== $_GET['key']) {
            return redirectx('/#/auth/error?error=activate-link&code=3');
        }

        $user->set('active', 1);
        $user->save();

        return redirectx('/#/auth/login?from=confirm-register');
    }


    /**
     * 
     */
    public function forgot()
    {
        $email = trim($_POST['email'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return jsonx([
                'success' => false,
                'message' => 'Введите корректный email',
            ]);
        }

        $profile = $this->modx->getObject('modUserProfile', ['email' => $email]);
        if (!$profile) {
            return jsonx([
                'success' => false,
                'message' => 'Пользователь с таким email не зарегистрирован на сайте',
            ]);
        }

        $password = bin2hex(random_bytes(4));
        $key = bin2hex(random_bytes(24));
        $_SESSION['new_password'] = $password;
        $_SESSION['new_password_key'] = $key;
        $_SESSION['new_password_email'] = $email;
        $reset_url = $this->modx->getOption('site_url') . "api/auth/reset-password?key={$key}";

        $email_params = [
            'subject' => 'Сброс пароля',
            'content' => parserx()->parse(file_get_contents(MODX_CORE_PATH . 'app/templates/emails/forgot.tpl'), [
                'title' => 'Сброс пароля',
                'reset_url' => $reset_url,
                'email' => $email,
                'password' => $password,
            ]),
        ];
        email($email, $email_params);

        return jsonx([
            'success' => true,
            'message' => 'Ссылка для сброса пароля выслана на указанный вами email. Если письмо не пришло, проверьте папку «Спам»'
        ]);
    }


    /**
     * 
     */
    public function reset_password()
    {        
        if (empty($_GET['key'])
            || empty($_SESSION['new_password'])
            || empty($_SESSION['new_password_key'])
            || empty($_SESSION['new_password_email'])
            || $_GET['key'] !== $_SESSION['new_password_key']
        ) {
            return redirectx('/#/auth/error?error=reset-link&code=1');
        }

        $profile = $this->modx->getObject('modUserProfile', ['email' => $_SESSION['new_password_email']]);
        if (!$profile) {
            return redirectx('/#/auth/error?error=reset-link&code=2');
        }

        $user = $this->modx->getObject('modUser', $profile->internalKey);
        $user->set('password', $_SESSION['new_password']);
        $user->save();
        $profile->set('blocked', 0);
        $profile->save();

        unset($_SESSION['new_password'], $_SESSION['new_password_key'], $_SESSION['new_password_email']);

        return redirectx('/#/auth/login?from=reset-password');
        // return jsonx([
        //     'success' => true,
        //     'message' => 'ок ' . $user->username,
        // ]);
    }
}
