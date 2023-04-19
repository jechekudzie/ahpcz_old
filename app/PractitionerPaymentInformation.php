<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PractitionerPaymentInformation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function practitioner(){

        return $this->belongsTo(Practitioner::class);
    }

    //practitioner payment info belongs to the following relations
    public function renewal_category(){

        return $this->belongsTo(RenewalCategory::class);
    }

    public function register_category(){

        return $this->belongsTo(RegisterCategory::class);
    }

    public function payment_method(){

        return $this->belongsTo(PaymentMethod::class);
    }

    public function employment_status(){

        return $this->belongsTo(EmploymentStatus::class);
    }

    public function employment_location(){

        return $this->belongsTo(EmploymentLocation::class);
    }
}
