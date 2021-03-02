<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practitioner extends Model
{
    //
    protected $guarded = [];


    public function currentRenewal()
    {
        $year = date('Y');
        return $this->hasOne(Renewal::class)->where('renewal_period_id', $year);
    }

    //register, renewal, payment method categories
    public function practitioner_payment_information()
    {

        return $this->hasOne(PractitionerPaymentInformation::class);
    }


    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }


    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }


    public function contact()
    {

        return $this->hasOne(PractitionerContact::class);
    }


    public function practitionerQualifications()
    {
        return $this->hasMany(PractitionerQualification::class);

    }

    public function documents()
    {

        return $this->hasMany(Document::class, 'document_owner');
    }




    public function employment_status(){
        return $this->belongsTo(EmploymentStatus::class);
    }

    public function employment_location(){
        return $this->belongsTo(EmploymentLocation::class);
    }





    public function employer()
    {
        return $this->hasOne(PractitionerEmployer::class);
    }


    public function registration()
    {
        return $this->hasOne(Registration::class);
    }

    public function renewals()
    {
        return $this->hasMany(Renewal::class);

    }

    public function cdPoints()
    {
        return $this->hasMany(PractitionerCpdpoint::class);
    }

    public function placement()
    {
        return $this->hasMany(PractitionerPlacement::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //practitioner registration requirements
    public function practitionerRequirements()
    {

        return $this->hasMany(PractitionerRequirement::class);
    }

    //application comments
    public function applicationComments()
    {
        return $this->hasMany(ApplicationComment::class);
    }

    //practitioner other applications
    public function otherApplications()
    {

        return $this->hasMany(OtherApplication::class);

    }

    /** start of Add functions */
    /*Adding contact*/
    public function addContact($contact)
    {
        $this->contact()->create($contact);
    }

    //add cpd points
    public function addCdPoints($cdpoints)
    {
        $this->cdPoints()->create($cdpoints);
    }

    //add placement
    public function addPlacement($placement)
    {
        $this->placement()->create($placement);
    }


    /*Adding qualification*/
    public function addPractitionerQualification($qualification)
    {

        $this->practitionerQualifications()->create($qualification);

    }

    //add documents
    public function addDocument($document)
    {

        $this->documents()->create($document);
    }

    //add other applications
    public function addOtherApplications($document)
    {
        $this->otherApplications()->create($document);
    }

    //add documents
    public function addEmployer($employer)
    {
        $this->employer()->create($employer);
    }

    //add practitioner payment information
    public function addPractitionerPaymentInformation($practitioner_payment_information)
    {
        $this->practitioner_payment_information()->create($practitioner_payment_information);
    }

    //add registration
    public function addRegistration($payment)
    {

        return $this->registration()->create($payment);
    }

    //add renewals
    public function addRenewal($payment)
    {

        return $this->renewals()->create($payment);
    }

    //add payments
    public function addPayment($payment)
    {

        $this->payments()->create($payment);
    }

    //add practitioner requirements
    public function addPractitionerRequirements($requirements)
    {

        $this->practitionerRequirements()->create($requirements);
    }

    //add application comments
    public function addComments($comments)
    {
        $this->applicationComments()->create($comments);
    }


    /** Live wire functions */
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('id', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('registration_number', 'like', '%' . $search . '%')
                ->orWhereDoesntHave('profession')->orWhereHas('profession', function ($query) use ($search) {
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
        }

        if ($compliance == 2) {

                return $query->orWhereDoesntHave('currentRenewal')->orWhereHas('currentRenewal', function ($query) use ($compliance) {
                    $query
                        ->where('renewal_status_id', '!=', 1)
                        ->orWhere('cdpoints', '=', 0)
                        ->orWhere('placement', '=', 0);
                });


        }

        return $query;

    }
    /** Live wire functions */

}
