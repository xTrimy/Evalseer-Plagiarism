<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    public function assignment(){
        return $this->belongsTo(Assignments::class);
    }
    public function test_cases()
    {
        return $this->hasMany(QuestionTestCases::class,'question_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'question_id');
    }
}
