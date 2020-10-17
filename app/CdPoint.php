<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CdPoint extends Model
{
    //
    protected $guarded = [];

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }



}
