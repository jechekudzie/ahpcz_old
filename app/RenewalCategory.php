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


    public function practitioner_payment_information(){

        return $this->hasMany(PractitionerPaymentInformation::class);
    }


    public function renewal_criterias(){
        return $this->hasMany(RenewalCriteria::class);
    }


}
