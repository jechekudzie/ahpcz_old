<?php

namespace App\Http\Controllers;

use App\AccreditedInstitution;
use App\City;
use App\CpdCriteria;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Gender;
use App\PaymentChannel;
use App\Practitioner;
use App\PractitionerQualification;
use App\Prefix;
use App\Profession;
use App\ProfessionalQualification;
use App\Province;
use App\QualificationCategory;
use App\Rate;
use App\RegisterCategory;
use App\Renewal;
use App\RenewalCriteria;
use App\Title;
use App\Vat;
use Illuminate\Http\Request;
use Paynow\Payments\Paynow;
use function GuzzleHttp\Promise\all;

class PortalApiController extends Controller
{
    //get profession for account verification
    public function get_professions()
    {
        $professions = Profession::with('prefix')->get();
        return response()->json([
            'professions' => $professions,
        ]);
    }

    //
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

    public function correct_data()
    {

        $practitioner_id = request('practitioner_id');

        $practitioner = Practitioner::where('id', $practitioner_id)->first();

        $data = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'primary_phone' => 'required',
            'physical_address' => 'required',
        ]);

        $practitioner->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);

        if ($practitioner->contact) {
            $practitioner->contact->update([
                'email' => $data['email'],
                'primary_phone' => $data['primary_phone'],
                'physical_address' => $data['physical_address'],
            ]);
        } else {
            $practitioner->contact->create([
                'email' => $data['email'],
                'primary_phone' => $data['primary_phone'],
                'physical_address' => $data['physical_address'],
            ]);
        }

        return response()->json([
            'message' => 'Information successfully correct, will wait for AHPCZ
             to verify your full name and registration number.',
        ]);


    }

    public function update_tracker(Practitioner $practitioner)
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
        if ($practitioner->currentRenewal) {
            $practitioner->currentRenewal;
        }
        if ($practitioner->payments) {
            $practitioner->payments;
        }
        return response()->json([
            'practitioner' => $practitioner,
            'rate' => Rate::find(1),
            'cpd_criterias' => CpdCriteria::all(),
            'renewal_criterias' => RenewalCriteria::all(),
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
        $practitioner = Practitioner::where('id', $practitioner_id)->first();
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
            'register_category_id' => 'nullable',

            'employer_name' => 'nullable',
            'business_address' => 'nullable',
            'contact_person' => 'nullable',
            'employer_phone' => 'nullable',
            'employer_email' => 'nullable',
            'employer_province' => 'nullable',
            'employer_city' => 'nullable',
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


        $employment_information['name'] = $data['employer_name'];
        $employment_information['business_address'] = $data['business_address'];
        $employment_information['contact_person'] = $data['contact_person'];
        $employment_information['phone'] = $data['employer_phone'];
        $employment_information['email'] = $data['employer_email'];
        $employment_information['province_id'] = $data['employer_province'];
        $employment_information['city_id'] = $data['employer_city'];

        if ($data['employment_status_id'] == 1) {
            if (empty($practitioner->employer)) {
                $practitioner->addEmployer($employment_information);
                $practitioner->update([
                    'employment_status_id' => 1
                ]);

            } else {
                $practitioner->employer->update($employment_information);
                $practitioner->update([
                    'employment_status_id' => 1
                ]);
            }
        }

        $practitioner_payment_information['register_category_id'] = $data['register_category_id'];
        $practitioner->practitioner_payment_information->update($practitioner_payment_information);

        return response()->json([
            'message' => 'Your information was updated successfully.',
        ]);

    }


    public function renewal_criteria
    (
        $renewal_category_id,
        $employment_status_id,
        $employment_location_id,
        $certificate_request
    )
    {
        $renewal_criteria = RenewalCriteria::
        where('renewal_category_id', $renewal_category_id)
            ->where('employment_status_id', $employment_status_id)
            ->where('employment_location_id', $employment_location_id)
            ->where('certificate_request', $certificate_request)->first();

        return response()->json([
            'renewal_criteria' => $renewal_criteria,
        ]);
    }

    public function create_renewal()
    {
        $cpd_criterias = CpdCriteria::all();
        $renewal_criterias = RenewalCriteria::all();
        $employment_statuses = EmploymentStatus::all();
        $employment_locations = EmploymentLocation::all();
        $payment_channels = PaymentChannel::all();
        $rate = Rate::find(1);
        $vat = Vat::find(1);

        return response()->json([

            'cpd_criterias' => $cpd_criterias,
            'renewal_criterias' => $renewal_criterias,
            'employment_statuses' => $employment_statuses,
            'employment_locations' => $employment_locations,
            'payment_channels' => $payment_channels,
            'rate' => $rate,
            'vat' => $vat->vat,
        ]);

    }

    public function make_payment()
    {
        $practitioner_id = request('practitioner_id');
        $practitioner = Practitioner::find($practitioner_id);
        $data = request()->validate([
            'period' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'payment_date' => 'required',
            'payment_channel_id' => 'required',
            'currency' => 'required',
            'pop' => 'nullable',

            'points' => 'required',
            'file' => 'nullable',

            'dob' => 'required',
            'employment_status_id' => 'required',
            'employment_location_id' => 'required',
            'certificate_request' => 'required',

            'practitioner_id' => 'required',
            'renewal_category_id' => 'required',
            'cpd_criteria' => 'required',
            'renewal_criteria_id' => 'required',
            'rate' => 'required',

        ]);
        $path = '';
        $status = 0;
        $practitioner->update([
            'employment_status_id' => $data['employment_status_id'],
            'employment_location_id' => $data['employment_location_id'],
            'dob' => $data['dob'],
        ]);

        //first step check to see if the amount invoice was full paid or there is a balance
        $renewal_balance = $data['amount_invoiced'] - $data['amount_paid'];

        $renewals['renewal_period_id'] = $data['period'];
        $renewals['practitioner_id'] = $practitioner->id;
        $renewals['payment_method_id'] = 1;
        $renewals['renewal_category_id'] = $data['renewal_category_id'];
        $renewals['currency'] = $data['currency'];
        $renewals['balance'] = $renewal_balance;
        $renewals['payment_type_id'] = 1; //a renewal payment type
        $renewals['certificate_request'] = $data['certificate_request'];
        $renewals['placement'] = 1;
        $renewals['renewal_criteria_id'] = $data['renewal_criteria_id'];

        if ($renewal_balance > 0) {
            $renewals['renewal_status_id'] = 3;
        } else {
            $renewals['renewal_status_id'] = 1;
        }

        //now check if the practitioner already for this current year
        if (Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            return response()->json([
                'status' => $status,
                'message' =>
                    'A renewal subscription for the selected period is already active,
                not that if this a regular payment click the payment link to proceed']);
        }
        else {
            $status = 1;
            if ($data['currency'] == 1) {
                $renewal_balance = $renewal_balance;
            }
            if ($data['currency'] == 0) {
                $renewal_balance = $renewal_balance / $data['rate'];
            }
            //add cpd points
            if (request()->hasfile('file')) {
                //get the file field data and name field from form submission
                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('cpdpoints', $file_name);
            }
            if ($data['points'] >= $data['cpd_criteria']) {
                $renewals['cdpoints'] = 1;
                $cpd_points['practitioner_id'] = $practitioner->id;
                $cpd_points['renewal_period_id'] = $data['period'];
                $cpd_points['points'] = $data['points'];
                $cpd_points['path'] = $path;
                $practitioner->addCdPoints($cpd_points);
            } else {
                $renewals['cdpoints'] = 0;
            }
            $add_renewal = $practitioner->addRenewal($renewals);
            $payments['renewal_period_id'] = $data['period'];
            $payments['renewal_id'] = $add_renewal->id;
            $payments['month'] = date('m');
            $payments['day'] = date('d');
            $payments['practitioner_id'] = $practitioner->id;
            $payments['balance'] = $renewal_balance;
            $payments['amount_invoiced'] = $data['amount_invoiced'];
            $payments['amount_paid'] = $data['amount_paid'];
            $payments['payment_channel_id'] = $data['payment_channel_id'];
            $payments['rate'] = $data['rate'];
            $payments['currency'] = $data['currency'];
            $payments['payment_item_category_id'] = 1;
            $payments['payment_date'] = $data['payment_date'];
            $payments['payment_item_id'] = 33;
            $payments['pop'] = $path;

            $add_renewal_payment = $add_renewal->addPayments($payments);


            //update previous balances to 0
            if ($renewal_balance > 0) {
                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            } else {

                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            }

            return response()->json([
                'status' => $status,
                'message' => 'Renewal Payment Was successful.',
            ]);

        }
    }

    public function make_restoration_payment()
    {
        $practitioner_id = (int)request('practitioner_id');
        $practitioner = Practitioner::find($practitioner_id);
        $amount_paid = 0;
        $amount_invoiced = 0;
        $path = '';
        $status = 0;
        $data = request()->validate([
            /*'period' => 'required',*/
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'payment_date' => 'required',
            'payment_channel_id' => 'required',
            'currency' => 'required',
            'pop' => 'nullable',

            'points' => 'required',
            'file' => 'nullable',

            'practitioner_id' => 'required',
            'rate' => 'required',

            'cpd_criteria' => 'required',

        ]);

        $data['period'] = date('Y');

        //first step check to see if the amount invoice was full paid or there is a balance
        $renewal_balance = $data['amount_invoiced'] - $data['amount_paid'];

        $renewals['renewal_period_id'] = $data['period'];
        $renewals['practitioner_id'] = $practitioner->id;
        $renewals['payment_method_id'] = 1;
        $renewals['renewal_category_id'] = 1;
        $renewals['currency'] = $data['currency'];
        $renewals['balance'] = $renewal_balance;
        $renewals['payment_type_id'] = 1; //a renewal payment type
        $renewals['certificate_request'] = 1;
        $renewals['placement'] = 1;
        $renewals['renewal_criteria_id'] = 1;

        if ($renewal_balance > 0) {
            $renewals['renewal_status_id'] = 3;
        } else {
            $renewals['renewal_status_id'] = 1;
        }
        //now check if the practitioner already for this current year
        if (Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            return response()->json([
                'status' => $status,
                'message' =>
                    'A renewal subscription for the selected period is already active.']);
        } else {
            $status = 1;
            if ($data['currency'] == 1) {
                //if currency ZWL
                $renewal_balance = $renewal_balance;
                $amount_paid = $data['amount_paid'];
                $amount_invoiced = $data['amount_invoiced'];
            }
            if ($data['currency'] == 0) {
                //if currency ZWL
                $renewal_balance = $renewal_balance / $data['rate'];
                $amount_paid = $data['amount_paid'] * $data['rate'];
                $amount_invoiced = $data['amount_invoiced'] * $data['rate'];
            }

            //add cpd points
            if (request()->hasfile('file')) {
                //get the file field data and name field from form submission
                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('cpdpoints', $file_name);
            }

            if ($data['points'] >= $data['cpd_criteria']) {
                $renewals['cdpoints'] = 1;
                $cpd_points['practitioner_id'] = $practitioner->id;
                $cpd_points['renewal_period_id'] = $data['period'];
                $cpd_points['points'] = $data['points'];
                $cpd_points['path'] = $path;
                $practitioner->addCdPoints($cpd_points);
            } else {
                $renewals['cdpoints'] = 0;
            }

            $add_renewal = $practitioner->addRenewal($renewals);
            $payments['renewal_period_id'] = $data['period'];
            $payments['renewal_id'] = $add_renewal->id;
            $payments['month'] = date('m');
            $payments['day'] = date('d');
            $payments['practitioner_id'] = $practitioner->id;
            $payments['balance'] = $renewal_balance;
            $payments['amount_invoiced'] = $amount_invoiced;
            $payments['amount_paid'] = $amount_paid;
            $payments['payment_channel_id'] = $data['payment_channel_id'];
            $payments['rate'] = $data['rate'];
            $payments['currency'] = $data['currency'];
            $payments['payment_item_category_id'] = 1;
            $payments['payment_date'] = $data['payment_date'];
            $payments['payment_item_id'] = 33;
            $payments['pop'] = $path;

            $add_renewal_payment = $add_renewal->addPayments($payments);

            //update previous balances to 0
            if ($renewal_balance > 0) {
                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            } else {

                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            }

            return response()->json([
                'status' => $status,
                'message' =>
                    'Renewal Payment was successful.']);

        }
    }

    public function make_online_payment()
    {
        $amount = request('amount');
        $practitioner_id = request('practitioner_id');
        $currency = request('currency');
        $period = request('period');
        $status = 0;
        if (Renewal::where('practitioner_id', $practitioner_id)->where('renewal_period_id', $period)->first()) {
            return response()->json([
                'status' => $status,
                'message' =>
                    'A renewal subscription for the selected period is already active
              ']);
        }

        $id = time() . $amount;
        //instantiate paynow object
        if ($currency == 1) {
            $paynow = new Paynow
            (
            //usd account
                /*'11778',
                '02f69090-68e9-427b-9838-966385aa0541',*/
                '5865',
                '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id,
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id

            );
        }

        if ($currency == 0) {
            $paynow = new Paynow
            (
            //local account
                '11777',
                '739d23ae-f8c5-45e0-ac0a-a481f615c813',
                /*'5865',
                '23962222-9610-4f7c-bbd5-7e12f19cdfc6',*/
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id,
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id

            );
        }

        //create a payment and add items required
        $payment = $paynow->createPayment($id, 'accounts@ahpcz.co.zw');
        $payment->add('Sub', $amount);
        //initiate payment
        $response = $paynow->send($payment);

        //check if initiation was a success
        if ($response->success()) {
            $status = 1;
            // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
            $payment_link = $response->redirectUrl();
            // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
            $pollUrl = $response->pollUrl();
            //create an array of data to be saved in the database
            $attributes['poll_url'] = $pollUrl;

            return response()->json([
                'status' => $status,
                'poll_url' => $pollUrl,
                'payment_link' => $payment_link,

            ]);
        } else {
            return response()->json([
                'status' => $status,
                'message' => 'Payment was unsuccessful, try again later',

            ]);
        }

    }

    public function make_online_restoration_payment()
    {
        $amount = request('amount');
        $practitioner_id = request('practitioner_id');
        $currency = request('currency');
        $period = request('period');
        $status = 0;
        if (Renewal::where('practitioner_id', $practitioner_id)->where('renewal_period_id', $period)->first()) {
            return response()->json([
                'status' => $status,
                'message' =>
                    'A renewal subscription for the selected period is already active.']);
        }
        $id = time() . $amount;
        //instantiate paynow object
        if ($currency == 1) {
            $paynow = new Paynow
            (
            //usd account
                '11778',
                '02f69090-68e9-427b-9838-966385aa0541',
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id,
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id

            );
        }

        if ($currency == 0) {
            $paynow = new Paynow
            (
            //local account
                '11777',
                '739d23ae-f8c5-45e0-ac0a-a481f615c813',
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id,
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id

            );
        }
        //create a payment and add items required
        $payment = $paynow->createPayment($id, 'accounts@ahpcz.co.zw');
        $payment->add('Sub', $amount);
        //initiate payment
        $response = $paynow->send($payment);

        //check if initiation was a success
        if ($response->success()) {
            $status = 1;
            // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
            $payment_link = $response->redirectUrl();
            // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
            $pollUrl = $response->pollUrl();
            //create an array of data to be saved in the database
            $attributes['poll_url'] = $pollUrl;

            return response()->json([
                'status' => $status,
                'poll_url' => $pollUrl,
                'payment_link' => $payment_link,

            ]);
        } else {
            return response()->json([
                'status' => $status,
                'message' => 'Payment was unsuccessful, try again later',

            ]);
        }

    }

    //qualifications
    public function get_qualification_data(Practitioner $practitioner)
    {
        $profession = Profession::whereId($practitioner->profession_id)->first();
        $qualification_categories = QualificationCategory::all();
        $professional_qualifications = ProfessionalQualification::
        where('profession_id', $profession->id)->get();

        if ($profession->professionalQualifications) {
            $profession->professionalQualifications;
            foreach ($profession->professionalQualifications as $professional_qualification) {
                foreach ($professional_qualification->accreditation as $accreditation) {
                    $accreditation->accreditedInstitution;
                }
            }
        }

        //$accredited_institutions = AccreditedInstitution::all();
        return response()->json([
            'profession' => $profession,
            'qualification_categories' => $qualification_categories
        ]);
    }

    public function get_qualification($id)
    {
        $qualification = PractitionerQualification::find($id);

        return response()->json([
            'qualification' => $qualification
        ]);
    }

    public function add_practitioner_qualification(Practitioner $practitioner)
    {

        $professional_details = request()->validate([
            'profession_id' => 'required',
            'qualification_category_id' => 'required',

        ]);

        if (request('qualification_category_id') == 1) {
            request()->validate([
                'professional_qualification_id' => ['required'],
                'accredited_institution_id' => ['required']
            ]);
            $professional_details['professional_qualification_id'] = request('professional_qualification_id');
            $professional_details['accredited_institution_id'] = request('accredited_institution_id');
        }

        if (request('qualification_category_id') == 2) {
            request()->validate([
                'professional_qualification_name' => ['required'],
                'institution' => ['required'],
            ]);

            $professional_details['professional_qualification_name'] = request('professional_qualification_name');
            $professional_details['institution'] = request('institution');

        }
        $professional_details['commencement_date'] = request('commencement_date');
        $professional_details['completion_date'] = request('completion_date');

        //save professional qualification
        $practitioner->addPractitionerQualification($professional_details);


        return response()->json([
            'message' => 'Professional qualification added successfully.',
        ]);

    }

    public function edit_practitioner_qualification(PractitionerQualification $practitionerQualification)
    {
        $profession_id = request('profession_id');

        if (request('qualification_category_id') == 1) {
            $professional_details = request()->validate([
                'professional_qualification_id' => ['required'],
                'accredited_institution_id' => ['required']

            ]);
            $practitionerQualification->update([
                'profession_id' => request('profession_id'),
                'qualification_category_id' => request('qualification_category_id'),
                'professional_qualification_id' => request('professional_qualification_id'),
                'accredited_institution_id' => request('accredited_institution_id'),

                //set these to null
                'professional_qualification_name' => null,
                'institution' => null,

                'commencement_date' => request('commencement_date'),
                'completion_date' => request('completion_date'),
            ]);


        }

        if (request('qualification_category_id') == 2) {
            $professional_details = request()->validate([
                'professional_qualification_name' => ['required'],
                'institution' => ['required'],
            ]);
            $practitionerQualification->update([
                'profession_id' => request('profession_id'),
                'qualification_category_id' => request('qualification_category_id'),
                'professional_qualification_name' => request('professional_qualification_name'),
                'institution' => request('institution'),

                //set these to null
                'professional_qualification_id' => null,
                'accredited_institution_id' => null,

                'commencement_date' => request('commencement_date'),
                'completion_date' => request('completion_date'),
            ]);

        }

        return response()->json([
            'message' => 'Practitioner qualification updated successfully',
        ]);

    }


    public function verify_certificate(Practitioner $practitioner)
    {

        if ($practitioner) {
            if($practitioner->currentRenewal){
                $practitioner->currentRenewal;
            }
            $practitioner->profession;
        }

        return response()->json([
            'practitioner' => $practitioner,

        ]);

    }

    public function testfile()
    {
        if (request()->hasfile('file')) {
            //get the file field data and name field from form submission
            $file = request()->file('file');

            //get file original name
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();

            //create a unique file name using the time variable plus the name
            $file_name = time() . $name . $ext;

            //upload the file to a directory in Public folder
            $path = $file->move('cpdpoints', $file_name);
        }

    }
}
