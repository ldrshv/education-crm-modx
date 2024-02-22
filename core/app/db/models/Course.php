<?php
namespace App\Models;

class Course extends \Illuminate\Database\Eloquent\Model
{
    public $table = 'app_courses';

    protected $guarded = ['id', 'created_at', 'updated_at', 'user_id', 'company_id'];
    
    protected $casts = [
        'created_at' => 'datetime:d.m.Y',
    ];

    protected $appends = [
        'author'
    ];

    public function getAuthorAttribute() {
        $profile = \App\Models\Profile::where('internalKey', $this->user_id)->first();
        return $profile ? $profile->email : $this->user_id;
    }
}