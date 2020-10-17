<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccreditedInstitution extends Model
{
    //

    protected $guarded = [];

    public function accreditation(){

        return $this->hasMany(Accreditation::class);
    }

    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }

    public function practitionerQualification(){

        return $this->hasMany(PractitionerQualification::class);
    }

}
