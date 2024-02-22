<?php
namespace App\Controllers;
use Zoomx\Controllers;

class User extends \Zoomx\Controllers\Controller
{
    /**
     * 
     */
    public function get()
    {
        $user = $this->modx->user;
        if (!$this->modx->user->isAuthenticated('web')) {
            return jsonx(['success' => false]);
        }
        
        $data = $user->getOne('Profile')->toArray();

        return jsonx(['success' => true, 'data' => $data]);
    }
}
