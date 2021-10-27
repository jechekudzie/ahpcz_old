<?php

namespace App\Http\Controllers\Api;

use App\CpdCriteria;
use App\Http\Controllers\Controller;
use App\Practitioner;
use App\Rate;
use App\RenewalCriteria;
use Illuminate\Http\Request;

class PractitionersController extends Controller
{
    //
    public function create(){

    }
    public function edit(){

    }

    public function store(){

    }

    public function update(){

    }
    public function show(Practitioner $practitioner){
        if ($practitioner->profession) {
            $practitioner->profession;
            if( $practitioner->profession->profession_tire){
                $practitioner->profession->profession_tire->tire;
            }

        }
        if ($practitioner->title) {
            $practitioner->title;
        }
        if ($practitioner->gender) {
            $practitioner->gender;
        }
        if ($practitioner->nationality) {
            $practitioner->nationality;
        }
        if ($practitioner->contact) {
            $practitioner->contact->city;
            $practitioner->contact->province;
        }
        $practitioner->employment_status;
        $practitioner->employment_location;
        if ($practitioner->employer) {
            $practitioner->employer;
            $practitioner->employer->city;
            $practitioner->employer->province;
        }
        if ($practitioner->practitionerQualifications) {
            foreach ($practitioner->practitionerQualifications as $practitionerQualification) {
                $practitionerQualification;
                $practitionerQualification->profession;
                $practitionerQualification->professionalQualification;
                $practitionerQualification->accreditedInstitution;
                $practitionerQualification->qualificationCategory;
            }
        }
        if ($practitioner->practitioner_payment_information) {
            $practitioner->practitioner_payment_information->renewal_category;
            $practitioner->practitioner_payment_information->register_category;
            $practitioner->practitioner_payment_information->payment_method;
        }
        if ($practitioner->renewals) {
            foreach ($practitioner->renewals as $renewal) {
                if ($renewal->renewalStatus) {
                    $renewal->renewalStatus;
                }
            }
        }
        if ($practitioner->currentRenewal) {
            $practitioner->currentRenewal;
        }
        $balance = 0;
        $payments = 0;
        $rate = Rate::find(1)->rate;
        if ($practitioner->payments) {
            $practitioner->payments;
            $payments = $practitioner->payments->sortByDesc('id')->take(5);
            if($payments) {
                foreach ($payments as $payment){
                    $payment->paymentItemCategory->name;
                    $payment->paymentItem->name;
                }
            }
            $balance = $practitioner->payments->sum('balance');
        }
        return response()->json([
            'practitioner' => $practitioner,
            'balance' => $balance,
            'rate' => $rate,
            'payments' => $payments,
        ]);
    }


    public function cpd_criterias($practitioner){
        $practitioner = Practitioner::where('id',$practitioner)->first();
        $cpd_criteria = CpdCriteria::where('profession_id', $practitioner->id)
            ->where('employment_status_id', $practitioner->employment_status_id)->first();
        if ($cpd_criteria == null) {
            $cpd_criteria = 0;
        } else {
            $cpd_criteria = $cpd_criteria->points;
        }

        return $cpd_criteria;
    }

}
