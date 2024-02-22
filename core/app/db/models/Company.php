<?php
namespace App\Models;

class Company extends \Illuminate\Database\Eloquent\Model {
    public $table = 'app_companys';

    protected $guarded = ['id'];
    
    protected $casts = [
        'createdon' => 'datetime:d.m.Y',
    ];

    protected $appends = [
        // 'vacancy_count',
        'courses_count',
        'author'
    ];

    // public function getVacancyCountAttribute() {
    //     return \App\Models\Vacancy::where('company_id', $this->id)->count();
    // }

    public function getCoursesCountAttribute() {
        return \App\Models\Course::where('company_id', $this->id)->count();
    }

    public function getAuthorAttribute() {
        $profile = \App\Models\Profile::where('internalKey', $this->user)->first();
        return $profile ? $profile->email : $this->user;
    }
}