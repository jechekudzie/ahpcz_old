<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function practitioners(){
        return $this->belongsTo(Practitioner::class);
    }

    public function renewal_criterias(){
        return $this->hasMany(RenewalCriteria::class);
    }
}

