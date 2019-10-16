<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    //
    protected $guarded = [];

    public  function paymentItemCategory(){
        return $this->belongsTo(PaymentItemCategory::class);
    }

    public  function paymentItemFee(){
        return $this->hasOne(PaymentItemFee::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }

    public function otherApplications(){
        return $this->hasMany(OtherApplication::class);
    }

}
