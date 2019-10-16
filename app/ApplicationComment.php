<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationComment extends Model
{
    //

    protected  $guarded = [];

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }
}
