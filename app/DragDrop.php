<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DragDrop extends Model
{
    public function question(){
        return $this->morphOne(Question::class,'questionable');
    }
    public function answers(){
        return $this->hasMany(CorrectAnswer::class);
    }
}
