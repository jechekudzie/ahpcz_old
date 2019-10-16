<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentItemFee extends Model
{
    //
    protected $guarded = [];

    public  function paymentItem(){
        return $this->belongsTo(PaymentItem::class);
    }
}
