{extends 'emails/email.tpl'}

{block 'main'}
    <p>
        Для сброса пароля на сайте {'site_name'|config} перейдите по ссылке ниже.
    </p>

    <p><a href="{$reset_url}">{$reset_url}</a></p>

    <p>После этого вы сможете зайти в личный кабинет, используя ваш email <strong>{$email}</strong> и новый пароль <strong>{$password}</strong></p>

    <p>Если вы не сбрасывали пароль на сайте, проигнорируйте это сообщение.</p>
{/block}