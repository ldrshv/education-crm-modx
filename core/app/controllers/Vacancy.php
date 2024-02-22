<?php
namespace App\Controllers;
use Zoomx\Controllers;

class Vacancy extends \Zoomx\Controllers\Controller
{
    /**
     * 
     */
    public function __construct($modx)
	{
		parent::__construct($modx);

        if (!$this->modx->user->isAuthenticated('web')) {
            return abortx(401);
        }

        require_once MODX_CORE_PATH . "app/vendor/autoload.php";
	}


    /**
     * 
     */
    public function new()
    {
        if (!isset($_POST['company_id'])) {
            return jsonx(['success' => false, 'message' => 'company_id is required']);
        }

        $can_create = (bool)\App\Models\Company::where(['id' => $_POST['company_id'], 'user' => $this->modx->user->id])->first()->id;
        if (!$can_create) {
            return jsonx(['success' => false, 'message' => 'access denied']);
        }

        $obj = \App\Models\Vacancy::create();
        $obj->company_id = $_POST['company_id'];
        $obj->user_id = $this->modx->user->id;
        $obj->save();

        return jsonx([
            'success' => true,
            'data' => ['id' => $obj->id],
        ]);
    }


    /**
     * 
     */
    public function get($id)
    {
        $data = \App\Models\Vacancy::find($id);
        return jsonx(['success' => (bool)$data, 'data' => $data]);
    }


    /**
     * 
     */
    public function update()
    {
        if (!isset($_POST['id'])) {
            return jsonx(['success' => false, 'message' => 'id is required']);
        }
        
        $obj = \App\Models\Vacancy::find($_POST['id']);
        $obj->update($_POST);

        return jsonx(['success' => true]);
    }


    /**
     * 
     */
    public function delete()
    {
        if (!isset($_POST['id'])) {
            return jsonx(['success' => false, 'message' => 'id is required']);
        }

        $obj = \App\Models\Vacancy::where('id', $_POST['id'])->where('user_id', $this->modx->user->id)->first();

        if (!$obj) {
            return jsonx(['success' => false, 'message' => 'vacancy not found']);
        }

        $obj->delete();

        return jsonx(['success' => true]);
    }


    /**
     * 
     */
    public function list()
    {
        if (!isset($_POST['company_id'])) {
            return jsonx(['success' => false, 'message' => 'company_id is required']);
        }

        $q = \App\Models\Vacancy::where('company_id', $_POST['company_id']);
        if (!isset($_POST['status']) || $_POST['status'] != 'all') {
            //$q->where('status', '!=', 'closed')->orWhere('status', null);

            $q->where(function ($q) { $q->where('status', '!=', 'closed')->orWhereNull('status'); });
        }
        $data = $q->get();

        return jsonx(['success' => true, 'data' => $data]);
    }

    
    /**
     * 
     */
    public function data()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.hh.ru/areas');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $areas = curl_exec($curl);
        curl_close($curl);
        $areas = json_decode($areas, true) ?? [];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.hh.ru/professional_roles');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
        $spec = curl_exec($curl);
        curl_close($curl);
        $spec = json_decode($spec, true) ?? [];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.hh.ru/dictionaries');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
        $dictionaries = curl_exec($curl);
        curl_close($curl);
        $dictionaries = json_decode($dictionaries, true) ?? [];

        $user = $this->modx->user;
        $profile = $user->getOne('Profile')->toArray();

        return jsonx(['success' => true, 'data' => [
            'areas' => $areas,
            'specializations' => $spec,
            'dictionaries' => $dictionaries,
            'profile' => $profile
        ]]);
    }


    public function suggests()
    {
        $url = '';
        if ($_GET['type'] == 'skills') {
            $url = "https://api.hh.ru/suggests/skill_set?text={$_GET['text']}";
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
        $items = curl_exec($curl);
        curl_close($curl);
        $items = json_decode($items, true) ?? [];

        return jsonx(['success' => true, 'data' => $items]);
    }

    /**
     * 
     */
    // public function delete()
    // {
    //     if (!isset($_POST['id'])) {
    //         return jsonx(['success' => false, 'message' => 'id is required']);
    //     }

    //     $obj = $this->modx->getObject('Company', [
    //         'user' => $this->modx->user->id,
    //         'id' => (int)$_POST['id'],
    //     ]);

    //     if (!$obj) {
    //         return jsonx(['success' => false, 'message' => "company with id {$_POST['id']} not found"]);
    //     }

    //     $success = (bool)$obj->remove();

    //     return jsonx([
    //         'success' => $success,
    //     ]);
    // }

}
