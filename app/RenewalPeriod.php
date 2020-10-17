<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenewalPeriod extends Model
{
    //
    protected $guarded = [];

    public function payments(){
        return $this->hasMany(RenewalPeriod::class);
    }

    public function renewals(){
        return $this->hasMany(Renewal::class);
    }
}
