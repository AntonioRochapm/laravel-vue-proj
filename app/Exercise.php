<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }
}
