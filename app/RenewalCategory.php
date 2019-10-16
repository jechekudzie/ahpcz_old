<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenewalCategory extends Model
{
    //

    protected $guarded = [];

    public  function renewalFee(){
        return $this->hasMany(RenewalFee::class);
    }

    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }
}
