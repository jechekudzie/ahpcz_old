<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //

    protected $guarded = [];

    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }
}
