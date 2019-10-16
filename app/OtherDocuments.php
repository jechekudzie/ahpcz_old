<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherDocuments extends Model
{
    //

    protected $guarded = [];

    public function otherApplication(){
        return $this->belongsTo(OtherApplication::class);
    }
}
