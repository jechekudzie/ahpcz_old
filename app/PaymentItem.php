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

    public function payment_item_requirements(){
        return $this->hasMany(PaymentItemRequirement::class);
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function add_payment_item_requirements($requirement){
        return $this->payment_item_requirements()->create($requirement);
    }

}
