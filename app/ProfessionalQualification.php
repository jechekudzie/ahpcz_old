<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessionalQualification extends Model
{
    //
    protected $guarded = [];


    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function accreditation(){

        return $this->hasMany(Accreditation::class);
    }

    public function practitionerQualification(){

        return $this->hasMany(PractitionerQualification::class);
    }

}
