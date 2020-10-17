<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    //

    protected $guarded = [];

    //practitioner Requirements
    public function practitionerRequirements(){

        return $this->hasMany(PractitionerRequirement::class);
    }
}
