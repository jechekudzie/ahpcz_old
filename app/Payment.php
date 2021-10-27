<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $guarded = [];

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }

    public function renewal(){
        return $this->belongsTo(Renewal::class);
    }

    public function renewalPeriod(){
        return $this->belongsTo(RenewalPeriod::class);
    }

    public function paymentItem(){
        return $this->belongsTo(PaymentItem::class);
    }

    public function paymentItemCategory(){
        return $this->belongsTo(PaymentItemCategory::class);
    }

    public function paymentChannel(){
        return $this->belongsTo(PaymentChannel::class);
    }





}
