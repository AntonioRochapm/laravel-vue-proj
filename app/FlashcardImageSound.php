<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlashcardImageSound extends Model
{
    public function question(){
        return $this->morphOne(Question::class,'questionable');
    }
}
