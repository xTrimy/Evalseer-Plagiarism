<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function course_groups($id){
        return Course::where('id',$id)->with('groups')->first();
    }
}
