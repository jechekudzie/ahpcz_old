<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    //
    protected $guarded = [];

    public function profession(){
        return $this->belongsTo(Profession::class);
    }
}
