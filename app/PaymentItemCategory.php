<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentItemCategory extends Model
{
    //
    protected $guarded = [];

    public function paymentItems(){
        return $this->hasMany(PaymentItem::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
