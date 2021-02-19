<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PractitionerQualification extends Model
{
    //

    protected $guarded = [];


    /*public function scopeLock($query)
    {
        return $query->where('locked', 0)->update(['locked' => 1]);
    }*/

    public function practitioner(){

        return $this->belongsTo(Practitioner::class);
    }

    public function profession(){

        return $this->belongsTo(Profession::class);
    }

    //relationship with professional qualification on practitioner qualification table
    public function professionalQualification(){

        return $this->belongsTo(ProfessionalQualification::class);
    }

    public function accreditedInstitution(){

        return $this->belongsTo(AccreditedInstitution::class);
    }

    public function qualificationCategory(){

        return $this->belongsTo(QualificationCategory::class);
    }
}
