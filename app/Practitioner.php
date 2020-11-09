<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practitioner extends Model
{
    //
    protected $guarded = [];


    public function professional_qualification()
    {
        return $this->belongsTo(ProfessionalQualification::class);
    }

    //livewire functions
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('id', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('registration_number', 'like', '%' . $search . '%')
                ->whereHas('profession', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", "%{$search}%")
                ->orWhereRaw("CONCAT(prefix, '', registration_number) LIKE ?", "%{$search}%");
    }


    public function scopeCheckCompliance($query, $compliance)
    {
        if ($compliance == 1) {
            return $query->whereHas('currentRenewal', function ($query) use ($compliance) {
                $query
                    ->where('renewal_status_id', '=', 1)
                    ->where('cdpoints', '=', 1)
                    ->where('placement', '=', 1);
            });
        } elseif ($compliance == 2) {
            return $query->whereHas('currentRenewal', function ($query) use ($compliance) {
                $query
                    ->where('renewal_status_id', '!=', 1)
                    ->orWhere('cdpoints', '=', 0)
                    ->orWhere('placement', '=', 0);
            });
        } else {

            return $query;

        }
    }


//end of livewire functions


    public function currentRenewal()
    {
        $year = date('Y');
        return $this->hasOne(Renewal::class)->where('renewal_period_id', $year);
    }


    public
    function title()
    {
        return $this->belongsTo(Title::class);
    }

    public
    function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public
    function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public
    function province()
    {
        return $this->belongsTo(Province::class);
    }

    public
    function city()
    {
        return $this->belongsTo(City::class);
    }

    public
    function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public
    function qualificationCategory()
    {
        return $this->belongsTo(QualificationCategory::class);
    }

    public
    function professionalQualification()
    {

        return $this->belongsTo(ProfessionalQualification::class);
    }


    public
    function accreditedInstitution()
    {
        return $this->belongsTo(AccreditedInstitution::class);
    }

    public
    function renewalCategory()
    {
        return $this->belongsTo(RenewalCategory::class);
    }

    public
    function registerCategory()
    {
        return $this->belongsTo(RegisterCategory::class);
    }

    public
    function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public
    function contact()
    {

        return $this->hasOne(PractitionerContact::class);
    }


    public
    function practitionerQualification()
    {

        return $this->hasMany(PractitionerQualification::class);

    }

    public
    function documents()
    {

        return $this->hasMany(Document::class, 'document_owner');
    }

    public
    function employer()
    {
        return $this->hasOne(PractitionerEmployer::class);
    }

    public
    function practitionerExperience()
    {

        return $this->hasMany(PractitionerExperience::class);
    }


    public
    function registration()
    {

        return $this->hasOne(Registration::class);
    }

    public
    function renewals()
    {
        return $this->hasMany(Renewal::class);

    }

//CPD points
    public
    function cdPoints()
    {
        return $this->hasMany(PractitionerCpdpoint::class);
    }

    public
    function placement()
    {
        return $this->hasMany(PractitionerPlacement::class);
    }


    public
    function payments()
    {
        return $this->hasMany(Payment::class);
    }


//practitioner Requirements
    public
    function practitionerRequirements()
    {

        return $this->hasMany(PractitionerRequirement::class);
    }

//application comments
    public
    function applicationComments()
    {
        return $this->hasMany(ApplicationComment::class);
    }

//practitioner other applications
    public
    function otherApplications()
    {

        return $this->hasMany(OtherApplication::class);

    }


    /*Adding contact*/
    public
    function addContact($contact)
    {
        $this->contact()->create($contact);
    }

//add cpd points
    public
    function addCdPoints($cdpoints)
    {
        $this->cdPoints()->create($cdpoints);
    }

//add placement
    public
    function addPlacement($placement)
    {
        $this->placement()->create($placement);
    }


    /*Adding qualification*/
    public
    function addPractitionerQualification($qualification)
    {

        $this->practitionerQualification()->create($qualification);

    }

//add documents
    public
    function addDocument($document)
    {

        $this->documents()->create($document);
    }

//add other applications
    public
    function addOtherApplications($document)
    {
        $this->otherApplications()->create($document);
    }

//add documents
    public
    function addEmployer($employer)
    {

        $this->employer()->create($employer);
    }

//add practitioner experience
    public
    function addExperience($experience)
    {

        $this->practitionerExperience()->create($experience);
    }

//add registration
    public
    function addRegistration($payment)
    {

        return $this->registration()->create($payment);
    }

//add renewals
    public
    function addRenewal($payment)
    {

        return $this->renewals()->create($payment);
    }

//add payments
    public
    function addPayment($payment)
    {

        $this->payments()->create($payment);
    }

//add practitioner requirements
    public
    function addPractitionerRequirements($requirements)
    {

        $this->practitionerRequirements()->create($requirements);
    }

//add application comments
    public
    function addComments($comments)
    {
        $this->applicationComments()->create($comments);
    }


    /** Update fields */


}
