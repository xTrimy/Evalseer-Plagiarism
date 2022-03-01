<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    use HasFactory;
    public $fillable=[
        "name",
        "description",
        "group_id",
        "submissions",
        "start_time",
        "end_time",
        "grade",
        "course_id",
        "pdf",
    ];

    public $casts = [
        'start_time'=>"datetime",
        'end_time'=>"datetime",
        'late_time'=>"datetime",
    ];

    public function questions(){
        return $this->hasMany(Questions::class,'assignment_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
