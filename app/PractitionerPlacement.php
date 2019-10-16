<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PractitionerPlacement extends Model
{
    //

    protected $guarded = [];

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }
}
