<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function payment_item_requirement(){
        return $this->belongsTo(PaymentItemRequirement::class);
    }


}
