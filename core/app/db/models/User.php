<?php
namespace App\Models;

// Класс профилей
class User extends \Illuminate\Database\Eloquent\Model {
    // Связь с таблицей профилей
    public function profile() {
        return $this->hasOne('App\Models\Profile', 'internalKey');
    }
}