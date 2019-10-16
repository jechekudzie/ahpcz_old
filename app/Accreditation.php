<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    //

    protected $guarded = [];

    public function professionalQualification(){
        return $this->belongsTo(ProfessionalQualification::class);
    }

    public function accreditedInstitution(){
        return $this->belongsTo(AccreditedInstitution::class);
    }

}
