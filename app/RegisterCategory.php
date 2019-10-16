<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterCategory extends Model
{
    //

    protected $guarded = [];

    public function practitioners(){
        return $this->hasMany(Practitioner::class);
    }
}
