<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenewalFee extends Model
{
    //
    protected $guarded = [];

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function renewalCategory(){
        return $this->belongsTo(RenewalCategory::class);
    }
}
