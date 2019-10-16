<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $guarded = [];

    //Relationships
    public function cities()
    {
        return $this->hasMany(City::class);
    }


    //create as per relationship
    public function createCity($task){

        $this->cities()->create($task);
    }


    public function practitioner(){
        return $this->hasMany(Practitioner::class);
    }

    public function practitionerEmployer(){
        return $this->hasMany(PractitionerEmployer::class);
    }

    public function practitionerExperience(){
        return $this->hasMany(PractitionerExperience::class);
    }

    public function contact(){
        return $this->hasMany(PractitionerContact::class);
    }


}
