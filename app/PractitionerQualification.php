<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PractitionerQualification extends Model
{
    //

    protected $guarded = [];

    public function practitioner(){

        return $this->belongsTo(Practitioner::class);
    }


    public function professionalQualification(){

        return $this->belongsTo(ProfessionalQualification::class);
    }

    public function accreditedInstitution(){

        return $this->belongsTo(AccreditedInstitution::class);
    }


    public function profession(){

        return $this->belongsTo(Profession::class);
    }

    public function qualificationCategory(){

        return $this->belongsTo(QualificationCategory::class);
    }
}
