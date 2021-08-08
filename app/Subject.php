<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
