<?php

namespace App\Http\Controllers;


use App\PractitionerRequirement;
use Illuminate\Http\Request;

class SubmittedRequirementsController extends Controller
{

    //update officer status
    public function store(PractitionerRequirement $practitionerRequirement)
    {

        $check = PractitionerRequirement::find($practitionerRequirement->id);

        if ($check->status == 1) {
            $practitionerRequirement->incomplete();
        } else {
            $practitionerRequirement->complete();
        }

        $practitioner = $practitionerRequirement->practitioner;
        $total = count($practitioner->practitionerRequirements);
        $checked = count($practitioner->practitionerRequirements->where('status','1'));

        $percentage =  ($checked/$total) * 100;
        echo number_format($percentage,2).'%';

    }

    //update member status
    public function storeMember(PractitionerRequirement $practitionerRequirement)
    {
        $check = PractitionerRequirement::find($practitionerRequirement->id);

        if ($check->member_status == 1) {
            $practitionerRequirement->incompleteMember();
        } else {
            $practitionerRequirement->completeMember();
        }

        $practitioner = $practitionerRequirement->practitioner;
        $total = count($practitioner->practitionerRequirements);
        $checked = count($practitioner->practitionerRequirements->where('member_status','1'));

        $percentage =  ($checked/$total) * 100;
        echo number_format($percentage,2).'%';

    }


}
