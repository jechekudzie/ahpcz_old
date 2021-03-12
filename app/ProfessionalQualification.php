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


    //relationship with the actually profession on creation
    public function profession(){
        return $this->belongsTo(Profession::class);
    }


    public function practitionerQualifications(){
        return $this->hasMany(PractitionerQualification::class);
    }


    public function accreditation(){

        return $this->hasMany(Accreditation::class);
    }



}
