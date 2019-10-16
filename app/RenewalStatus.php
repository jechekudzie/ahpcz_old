<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenewalStatus extends Model
{
    //
    protected $guarded = [];

    public function renewal(){
        return $this->hasMany(Renewal::class);
    }
}
