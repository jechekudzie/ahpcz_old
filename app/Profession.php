<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //
    protected $guarded = [];

    public function prefix(){
        return $this->hasOne(Prefix::class);
    }

    public function practitionerQualifications(){
        return $this->hasMany(PractitionerQualification::class);
    }

    public function cdpoint(){
        return $this->hasOne(CdPoint::class);
    }

    public  function renewalFee(){
        return $this->hasMany(RenewalFee::class);
    }

    public  function profession_tires(){
        return $this->hasMany(ProfessionTire::class);
    }




    public function professionApprover(){

        return $this->hasOne(ProfessionApprover::class);
    }


    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }

    public function professionalQualifications(){
        return $this->hasMany(ProfessionalQualification::class);
    }

    public function cpd_criterias(){
        return $this->hasMany(CpdCriteria::class);
    }


}
