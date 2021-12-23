<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function add($id){
        $assignment = Assignments::find($id);
        return view('instructor.add-question',["assignment"=>$assignment]);
    }
}
