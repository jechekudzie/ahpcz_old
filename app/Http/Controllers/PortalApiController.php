<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\Prefix;
use App\Profession;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class PortalApiController extends Controller
{
    //
    public function sign_up()
    {
        $professions = Profession::with('prefix')->get();
        return response()->json([
            'professions' => $professions,
        ]);
    }

    public function check_practitioner()
    {
        $data = request()->validate([
            'number' => 'required',
            'prefix' => 'required',
            'id_number' => 'required'
        ]);
        $registration_number = $data['number'];
        $id_number =  $data['id_number'];
        $prefix =  $data['prefix'];

        $practitioner = Practitioner::where('registration_number',$registration_number)
            ->where('prefix',$prefix)
            ->where('id_number',$id_number)
            ->first();
        if ($practitioner != null) {
            if ($practitioner->contact) {
                $practitioner->contact->city;
                $practitioner->contact->province;
            }
            if($practitioner->practitionerQualifications) {
                foreach ($practitioner->practitionerQualifications as $practitionerQualification) {
                    $practitionerQualification;
                    $practitionerQualification->profession;
                    $practitionerQualification->professionalQualification;
                    $practitionerQualification->accreditedInstitution;
                    $practitionerQualification->qualificationCategory;
                }
            }
            //practitioner employment status and location
            $practitioner->employment_status;
            $practitioner->employment_location;

            return response()->json([
                'practitioner' => $practitioner
            ]);
        }

    }


}
