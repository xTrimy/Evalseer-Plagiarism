<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    public function plagiarism_report(){
        return $this->hasMany(PlagiarismReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
