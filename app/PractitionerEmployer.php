<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PractitionerEmployer extends Model
{
    //

    protected $guarded = [];

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }



}
