<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    //

    protected $guarded = [];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function practitioner(){

        return $this->belongsTo(Practitioner::class);

    }

    public function renewalPeriod(){

        return $this->belongsTo(RenewalPeriod::class);
    }

    public function practitionerBalances(){
        return $this->hasMany(PractitionerBalance::class);
    }
    //every renewal has a status on its period
    public function renewalStatus(){
        return $this->belongsTo(RenewalStatus::class);
    }

    public function practitionerCdpoints(){
        return $this->hasOne(PractitionerCpdpoint::class);
    }


    //add
    public function addPayments($payment){

       return $this->payments()->create($payment);
    }

    public function addPractitionerCdPoints($cdpoints){

        $this->practitionerCdpoints()->create($cdpoints);
    }

}
