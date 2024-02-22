<?php
namespace App\Models;

// Класс профилей
class Profile extends \Illuminate\Database\Eloquent\Model {
    public $table = 'user_attributes';
    //Связь с таблицей пользователей
    public function user() {
        return $this->belongsTo('App\Models\User', 'internalKey');
    }
}