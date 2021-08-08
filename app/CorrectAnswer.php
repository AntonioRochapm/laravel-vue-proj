<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectAnswer extends Model
{
    protected $fillable = ['drag_drop_id','answer'];

    public function dragdrop(){
        return $this->hasOne(DragDrop::class);
    }
}

//teste teste
