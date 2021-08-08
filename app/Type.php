<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
