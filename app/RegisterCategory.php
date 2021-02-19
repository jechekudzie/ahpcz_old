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

    public function practitioner_payment_information(){
        return $this->hasMany(PractitionerPaymentInformation::class);
    }
}
