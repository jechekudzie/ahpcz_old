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
    public function practitioner_payment_information(){

        return $this->hasMany(PractitionerPaymentInformation::class);
    }
}
