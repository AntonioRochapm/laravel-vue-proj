<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoryGame extends Model
{
    public function question(){
        return $this->morphOne(Question::class,'questionable');
    }
}
