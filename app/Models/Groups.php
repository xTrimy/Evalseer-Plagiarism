<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;


    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignments::class,'group_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
