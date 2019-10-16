<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    //

    protected $guarded = [];

    public function practitioner(){

        return $this->belongsTo(Practitioner::class);
    }
}
