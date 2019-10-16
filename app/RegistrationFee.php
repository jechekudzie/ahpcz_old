<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationFee extends Model
{
    //

    protected $guarded = [];

    public function qualificationCategory(){
        return $this->belongsTo(QualificationCategory::class);
    }
}
