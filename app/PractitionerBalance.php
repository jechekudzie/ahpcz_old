<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PractitionerBalance extends Model
{
    //

    protected $guarded = [];

    public function renewal(){
        return $this->belongsTo(Renewal::class);
    }
}
