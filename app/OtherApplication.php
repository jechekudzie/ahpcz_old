<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherApplication extends Model
{
    //
    protected $guarded = [];

    public function practitioner(){

        return $this->belongsTo(Practitioner::class);

    }

    public function paymentItem(){
        return $this->belongsTo(PaymentItem::class);
    }

    public function otherDocuments(){
        return $this->hasMany(OtherDocuments::class);
    }


}
