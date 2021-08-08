<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=['exercise_id', 'questionable_id', 'questionable_type'];

    public function exercise(){
        return $this->belongsTo(Exercise::class);
    }
    public function questionable(){
        return $this->morphTo();
    }
}
