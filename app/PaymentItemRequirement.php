<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentItemRequirement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment_item(){
        return $this->belongsTo(PaymentItem::class);
    }

    public function application_documents(){
        return $this->hasMany(ApplicationDocument::class);
    }
}
