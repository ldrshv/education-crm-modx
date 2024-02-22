<?php
namespace App\Controllers;
use Zoomx\Controllers;

class Course extends \Zoomx\Controllers\Controller
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

        //$_POST = json_decode(file_get_contents('php://input'), true);

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

        $can_create = (bool)\App\Models\Company::where(['id' => (int)$_POST['company_id'], 'user' => $this->modx->user->id])->first()->id;
        if (!$can_create) {
            return jsonx(['success' => false, 'message' => 'access denied']);
        }

        $obj = \App\Models\Course::create($_POST);
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
        $data = \App\Models\Course::find($id);
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

        $q = \App\Models\Course::where('company_id', $_POST['company_id']);
        if (!isset($_POST['status']) || $_POST['status'] != 'all') {
            $q->where(function ($q) { $q->where('status', '!=', 'closed')->orWhereNull('status'); });
        }
        $data = $q->get();

        return jsonx(['success' => true, 'data' => $data]);
    }

}
