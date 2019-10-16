<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $guarded = [];


    public function province(){

        return $this->belongsTo(Province::class);
    }


    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }

    public function contact(){
        return $this->hasMany(PractitionerContact::class);
    }

    public function practitionerExperience(){
        return $this->hasMany(PractitionerExperience::class);
    }
}
