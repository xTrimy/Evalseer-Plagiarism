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
}
