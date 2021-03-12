<?php

namespace App\Http\Controllers;

use App\City;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Gender;
use App\Practitioner;
use App\Prefix;
use App\Profession;
use App\Province;
use App\QualificationCategory;
use App\RegisterCategory;
use App\Title;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class PortalApiController extends Controller
{
    //
    public function get_professions()
    {
        $professions = Profession::with('prefix')->get();
        return response()->json([
            'professions' => $professions,
        ]);
    }

    public function verify_ahpcz_account()
    {
        $data = request()->validate([
            'number' => 'required',
            'prefix' => 'required',
            'id_number' => 'required'
        ]);
        $registration_number = $data['number'];
        $id_number = $data['id_number'];
        $prefix = $data['prefix'];

        $practitioner = Practitioner::where('registration_number', $registration_number)
            ->where('prefix', $prefix)
            ->where('id_number', $id_number)
            ->first();
        $profession = Profession::all();
        if ($practitioner != null) {
            if ($practitioner->profession) {
                $practitioner->profession;
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
                    if ($renewal->payments) {
                        foreach ($renewal->payments as $payment) {
                            $payment->paymentItem;
                            $payment->paymentItemCategory;
                            $payment->paymentChannel;
                        }
                    }
                }
            }


            //practitioner contacts
            if ($practitioner->contact) {
                $practitioner->contact->city;
                $practitioner->contact->province;
            }
            return response()->json([
                'practitioner' => $practitioner,
            ]);
        }
    }

    public function update_tracker(Practitioner $practitioner)
    {
        if ($practitioner->profession) {
            $practitioner->profession;
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
                if ($renewal->payments) {
                    foreach ($renewal->payments as $payment) {
                        $payment->paymentItem;
                        $payment->paymentItemCategory;
                        $payment->paymentChannel;
                    }
                }
            }
        }

        return response()->json([
            'practitioner' => $practitioner,
        ]);
    }

    public function update_information_create()
    {

        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all();
        $employment_locations = EmploymentLocation::all();
        $qualification_categories = QualificationCategory::all();
        $register_categories = RegisterCategory::all();
        $professions = Profession::all()->sortBy('name');
        $provinces = Province::all()->sortBy('name');
        $cities = City::all()->sortBy('name');
        foreach ($professions as $profession) {
            if ($profession->professionalQualifications) {
                foreach ($profession->professionalQualifications as $professionalQualification) {
                    if ($professionalQualification->accreditation) {
                        foreach ($professionalQualification->accreditation as $institution) {
                            $institution->accreditedInstitution;
                        }
                    }


                }
            }
        }

        //dd($professions);

        return response()->json([
            'titles' => $titles,
            'genders' => $genders,
            'employment_statuses' => $employment_statuses,
            'employment_locations' => $employment_locations,
            'qualification_categories' => $qualification_categories,
            'register_categories' => $register_categories,
            'professions' => $professions,
            'provinces' => $provinces,
            'cities' => $cities,
        ]);
    }

    public function update_information_store()
    {
        $practitioner_id = request('practitioner_id');
        $practitioner = Practitioner::where('id',$practitioner_id)->first();
        $data = request()->validate([
            'practitioner_id' => 'nullable',
            'title_id' => 'nullable',
            'gender_id' => 'nullable',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'previous_name' => 'nullable',
            'id_number' => 'nullable',
            'profession_id' => 'nullable',
            'prefix' => 'nullable',
            'registration_number' => 'nullable',
            'employment_status_id' => 'nullable',
            'employment_location_id' => 'nullable',
            'dob' => 'nullable',
            'physical_address' => 'nullable',
            'email' => 'nullable',
            'primary_phone' => 'nullable',
            'secondary_phone' => 'nullable',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'register_category_id' => 'nullable'
        ]);

        $personal_information['title_id'] = $data['title_id'];
        $personal_information['gender_id'] = $data['gender_id'];
        $personal_information['first_name'] = $data['first_name'];
        $personal_information['last_name'] = $data['last_name'];
        $personal_information['previous_name'] = $data['previous_name'];
        $personal_information['id_number'] = $data['id_number'];
        $personal_information['profession_id'] = $data['profession_id'];
        $personal_information['prefix'] = $data['prefix'];
        $personal_information['registration_number'] = $data['registration_number'];
        $personal_information['employment_status_id'] = $data['employment_status_id'];
        $personal_information['employment_location_id'] = $data['employment_location_id'];
        $personal_information['dob'] = $data['dob'];

        $practitioner->update($personal_information);
        $contact_information['physical_address'] = $data['physical_address'];
        $contact_information['email'] = $data['email'];
        $contact_information['primary_phone'] = $data['primary_phone'];
        $contact_information['secondary_phone'] = $data['secondary_phone'];
        $contact_information['province_id'] = $data['province_id'];
        $contact_information['city_id'] = $data['city_id'];
        $practitioner->contact->update($contact_information);

        $practitioner_payment_information['register_category_id'] = $data['register_category_id'];
        $practitioner->practitioner_payment_information->update($practitioner_payment_information);

        return response()->json([
            'message' => 'Successfully updated details',
        ]);

    }
}
