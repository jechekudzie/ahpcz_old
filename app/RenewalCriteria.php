<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewalCriteria extends Model
{
    use HasFactory;
    protected $guarded = [];

    public  function renewal_category(){
        return $this->belongsTo(RenewalCategory::class);
    }

    public  function employment_status(){
        return $this->belongsTo(EmploymentStatus::class);
    }

    public  function employment_location(){
        return $this->belongsTo(EmploymentLocation::class);
    }
    

}
