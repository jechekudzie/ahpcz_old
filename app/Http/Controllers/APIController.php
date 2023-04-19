<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Practitioner;
use App\PractitionerPaymentInformation;
use App\PractitionerQualification;
use App\Prefix;
use App\Profession;
use App\ProfessionalQualification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Paynow\Payments\Paynow;
use PhpParser\Node\Expr\BinaryOp\Concat;

class APIController extends Controller
{

    public function makePayment()
    {
        $amount = request('amount');
        $practitioner_id = request('practitioner_id');

        $id = time() . $amount;
        //instantiate paynow object
        $paynow = new Paynow
        (
            /*'5771',
            '2e958d52-a3f9-4b6b-b845-2654a21a7458',*/

            '5865',
            '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
            'http://database.ahpcz.co.zw/check_payment/' . $practitioner_id,
            'http://database.ahpcz.co.zw/check_payment/' . $practitioner_id
        );

        //create a payment and add items required
        $payment = $paynow->createPayment($id, 'accounts@ahpcz.co.zw');
        $payment->add('Sub', $amount);
        //initiate payment
        $response = $paynow->send($payment);

        //check if initiation was a success
        if ($response->success()) {
            // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
            $payment_link = $response->redirectUrl();
            // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
            $pollUrl = $response->pollUrl();
            //create an array of data to be saved in the database
            $attributes['poll_url'] = $pollUrl;

            return response()->json([
                'poll_url' => $pollUrl,
                'payment_link' => $payment_link,

            ]);
        }else{
            return response()->json([
                'message' => 'Payment was unsuccessful, try again later',

            ]);
        }

    }

    public function create()
    {
        $professions = Profession::all()->sortBy('name');
        $prefixes = Prefix::all()->sortBy('name');

        return response()->json([
            'professions' => $professions->toArray(),
            'prefixes' => $prefixes->toArray()

        ]);
    }

    public function show(Practitioner $practitioner)
    {
        if ($practitioner->profession) {
            $practitioner->profession;
            $practitioner->profession->profession_tire->tire;
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
                if ($renewal->payments) {
                    foreach ($renewal->payments as $payment) {
                        $payment->paymentItem;
                        $payment->paymentItemCategory;
                        $payment->paymentChannel;
                    }
                }
            }
        }
        if ($practitioner->payments) {
            $practitioner->payments;
        }
        return response()->json([
            'practitioner' => $practitioner,
        ]);
    }

    public function update_qualification()
    {

        $practitioners = Practitioner::all();

        foreach ($practitioners as $practitioner) {

            if ($practitioner->practitionerQualifications->count()) {
                ///if relationship exists then nullify all fields in practitioner table
                $practitioner->update([
                    'qualification_category_id' => null,
                    'professional_qualification_id' => null,
                    'accredited_institution_id' => null,
                    'institution' => null,
                    'commencement_date' => null,
                    'completion_date' => null,
                ]);

            } else {

                $create = PractitionerQualification::create([
                    'practitioner_id' => $practitioner->id,
                    'profession_id' => $practitioner->profession_id,
                    'qualification_category_id' => $practitioner->qualification_category_id,
                    'professional_qualification_id' => $practitioner->professional_qualification_id,
                    'accredited_institution_id' => $practitioner->accredited_institution_id,
                    'institution' => $practitioner->institution,
                    'commencement_date' => $practitioner->commencement_date,
                    'completion_date' => $practitioner->completion_date,
                ]);
            }
        }
    }

    public function update_practitioner_payment_info()
    {
        //please note that for the first time, we dont have a single record in practitioner payment since
        //its a new table

        $practitioners = Practitioner::all();

        foreach ($practitioners as $practitioner) {

            if ($practitioner->practitioner_payment_information) {
                ///if relationship exists then nullify all fields in practitioner table
                $practitioner->update([
                    'renewal_category_id' => null,
                    'register_category_id' => null,
                    'payment_method_id' => null,
                ]);

            } else {
                $create = PractitionerPaymentInformation::create([
                    'practitioner_id' => $practitioner->id,
                    'renewal_category_id' => $practitioner->renewal_category_id,
                    'register_category_id' => $practitioner->register_category_id,
                    'payment_method_id' => $practitioner->payment_method_id,
                ]);

                $practitioner->update([
                    'renewal_category_id' => null,
                    'register_category_id' => null,
                    'payment_method_id' => null,
                ]);

            }
        }
    }


    public function index(Request $request)
    {
        $practitioners = Practitioner::all();
        $users = User::all();

        //if ($request->is('api/json/practitioners')) {
        return response()->json([
            'practitioners' => $practitioners->toArray(),
            'users' => $users->toArray()
        ]);

        //}


    }

    public function postPractitioner(Request $request)
    {
        $id = request('id');
        $practitioner = Practitioner::where('id', $id)->first();
        //practitioner contacts
        if (!empty($practitioner->contact)) {
            $practitioner->contact->city;
            $practitioner->contact->province;
        }

        //practitioner qualifications
        if ($practitioner->practitionerQualifications) {
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

        //practitioner employer
        if ($practitioner->employer) {
            $practitioner->employer->city;
            $practitioner->employer->province;
        }

        //practitioner contacts
        if ($practitioner->practitioner_payment_information) {
            $practitioner->practitioner_payment_information->renewal_category;
            $practitioner->practitioner_payment_information->register_category;
            $practitioner->practitioner_payment_information->payment_method;
        }

        $professions = Profession::all();
        return response()->json([
            'practitioner' => $practitioner->toArray(),
            'professions' => $professions,
        ]);


    }


    //registration number digit only
    public
    function byRegID(Request $request, $registration_number, $id_number)
    {
        $result = Practitioner::whereRegistrationNumberAndIdNumber($registration_number, $id_number)->first();

        //convert practitioner array to eloquent model
        $practitioner = Practitioner::find($result->id);

        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;


        if ($request->is('api/json/practitioners/' . $registration_number . '/' . $id_number)) {
            return response()->json([
                'practitioners' => $practitioner->toArray(),

            ]);

        }


    }

//registration number string
    public
    function byRegString(Request $request, $registration_number)
    {
        $registration = str_replace('*', '/', $registration_number);

        $result = Practitioner::whereRaw("CONCAT(`prefix`, `registration_number`) = ?", [$registration])->first();

        //convert practitioner array to eloquent model
        $practitioner = Practitioner::find($result->id);

        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;


        if ($practitioner != null) {

            if ($request->is('api/json/practitioner_reg_number/' . $registration_number)) {
                return response()->json([
                    'practitioner' => $practitioner->toArray(),
                ]);

            }
        } else {
            return response()->json([
                'message' => "Details do not match our record, please check registration and id "
            ]);
        }


    }

    public
    function byRegIdString(Request $request, $registration_number, $id_number)
    {
        $registration = str_replace('*', '/', $registration_number);

        $result = Practitioner::whereRaw("CONCAT(`prefix`, `registration_number`) = ? AND id_number = ?", [$registration, $id_number])->first();

        //convert practitioner array to eloquent model
        $practitioner = Practitioner::find($result->id);

        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;


        if ($practitioner != null) {
            if ($request->is('api/json/practitioner_string/' . $registration_number . '/' . $id_number)) {
                return response()->json([
                    'practitioner' => $practitioner->toArray(),
                ]);

            }
        } else {
            return response()->json([
                'message' => "Details do not match our record, please check registration and id "
            ]);
        }


    }

    public
    function testBoth()
    {
        $reg_number = "A/PSY0412";
        $id_number = "63915996H26";

        /*$reg_number = "A/AT0004";
        $id_number  = "43125772P";*/

        $reg_number = strtoupper($reg_number);
        $id_number = strtoupper($id_number);

        $fa = str_replace("/", "*", $reg_number);

        return redirect('/api/json/practitioner_string/' . $fa . '/' . $id_number);

    }

    public
    function testSingle()
    {

        $pqs = Prefix::all();

        foreach ($pqs as $pq) {
            echo '["id"=>"' . $pq->id . '","profession_id"=>"' . $pq->profession_id . '","name"=>"' . $pq->name . '","created_at"=>now(),"updated_at"=>now()],<br/>';

        }


        //$reg_number = "A/SU0026";

        //$reg_number = "A/AT0115";

        //$reg_number = "A/AT0004";


        //$reg_number = strtoupper($reg_number);


        //$fa = str_replace("/", "*", $reg_number);

        //return redirect('/api/json/practitioner_reg_number/' . $fa);


    }

}
