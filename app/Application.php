<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function application_documents(){
        return $this->hasMany(ApplicationDocument::class);
    }

    public function payment_item(){
        return $this->belongsTo(PaymentItem::class);
    }

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }

}
