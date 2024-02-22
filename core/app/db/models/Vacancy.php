<?php
namespace App\Models;

class Vacancy extends \Illuminate\Database\Eloquent\Model
{
    public $table = 'app_vacancys';

    protected $guarded = ['id', 'created_at', 'updated_at', 'user_id', 'company_id', 'manager_id'];
    
    protected $casts = [
        'areas' => 'array',
        'salary' => 'array',
        'address' => 'array',
        'key_skills' => 'array',
        'contacts' => 'array',
        'employment' => 'array',
        'working_time_modes' => 'array',
        'languages' => 'array',
        'driver_license_types' => 'array',
        'misc' => 'array',
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