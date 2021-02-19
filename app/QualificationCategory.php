<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationCategory extends Model
{
    //
    protected $guarded = [];

    public function registrationFees(){
        return $this->hasMany(RegistrationFee::class);
    }


    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }

    public function practitionerQualifications(){
        return $this->hasMany(PractitionerQualification::class);
    }

}
