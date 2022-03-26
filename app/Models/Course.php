<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public $fillable = [
        "name",
        "course_id",
        "credit_hours"
    ];

    public $casts = [
        "credit_hours"=>"integer"
    ];

    public function groups(){
        return $this->hasMany(Groups::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignments::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function programming_languages()
    {
        return $this->belongsToMany(ProgrammingLanguage::class, 'course_programming_languages');
    }
}
