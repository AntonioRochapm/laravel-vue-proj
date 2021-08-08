<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['is_admin'];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function user(){
        return $this->morphOne(User::class,'userable');
    }
}
