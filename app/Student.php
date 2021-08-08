<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_number','group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user(){
        return $this->morphOne(User::class,'userable');
    }
}
