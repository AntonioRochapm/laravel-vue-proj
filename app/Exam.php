<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
