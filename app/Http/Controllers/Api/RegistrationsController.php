<?php

namespace App\Http\Controllers\Api;

use App\Application;
use App\ApplicationDocument;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Gender;
use App\Http\Controllers\Controller;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\FinalRegistrationPayment;
use App\Notifications\RegistrarApproval;
use App\Notifications\RegistrationPayment;
use App\Payment;
use App\PaymentItem;
use App\Practitioner;
use App\Prefix;
use App\Profession;
use App\QualificationCategory;
use App\Rate;
use App\RegisterCategory;
use App\Renewal;
use App\Requirement;
use App\Title;
use App\User;
use Illuminate\Http\Request;

class RegistrationsController extends Controller
{
    //For front end
    public function professions()
    {
        $professions = Profession::all()->sortBy('name');
        foreach ($professions as $profession) {
            if ($profession->profession_tire) {
                $profession->profession_tire->tire;
            }
        }
        $registers = RegisterCategory::all();
        return response()->json([
            'professions' => $professions,
            'rate' => Rate::find(1)->rate,
            'application_fee' => PaymentItem::find(43)->fee,
            'registers' => $registers,
        ]);

    }

    public function requirements()
    {
        $locals = Requirement::whereNotIn('group', ['foreigners'])->get();
        $foreigners = Requirement::all();

        return response()->json([
            'locals' => $locals,
            'foreigners' => $foreigners,
            'rate' => Rate::find(1)->rate,
            'application_fee' => PaymentItem::find(43)->fee,
        ]);
    }

    public function application()
    {
        $professions = Profession::with('prefix')->get();
        foreach ($professions as $profession) {
            if ($profession->profession_tire) {
                $profession->profession_tire->tire;
            }
        }
        $titles = Title::all();
        $genders = Gender::all();
        $employment_statuses = EmploymentStatus::all();
        $employment_locations = EmploymentLocation::all();
        $qualification_categories = QualificationCategory::all();

        $application = PaymentItem::find(43);
        if ($application) {
            $application->paymentItemCategory;
        }

        return response()->json([
            'professions' => $professions,
            'qualification_categories' => $qualification_categories,
            'employment_statuses' => $employment_statuses,
            'employment_locations' => $employment_locations,
            'titles' => $titles,
            'genders' => $genders,
            'rate' => Rate::find(1)->rate,
            'application_details' => $application,
        ]);
    }

    //submit data
    public function step_1(Request $request)
    {

        //first check if id/passport number and profession is available
        request()->validate([
            'id_number' => 'nullable',
            'profession_id' => 'required',
            'employment_status_id' => 'nullable',
            'employment_location_id' => 'nullable',
        ]);

        $check_id_number = request('id_number');
        $check_profession_id = request('profession_id');

        $check_existensce = Practitioner::where('id_number', $check_id_number)
            ->where('profession_id', $check_profession_id)->first();

        //if the practitioner exists display message
        if ($check_existensce != null) {

            return response()->json([
                'response_status' => 0,
                'message' => 'Practitioner with the same ID/Passport number already exist in our system. If you want to add an additional application, use our portal at localhost:8000/login',

            ]);
        } else {
            $personal_details = request()->validate([
                'title_id' => ['required'],
                'gender_id' => ['required'],
                'first_name' => ['required'],
                'last_name' => ['required'],
                'dob' => ['required'],
                'id_number' => 'required',
                'profession_id' => ['required'],
                'qualification_category_id' => ['nullable'],
                'professional_qualification_id' => ['nullable'],
                'commencement_date' => ['required'],
                'completion_date' => ['required'],
                'registration_number' => 'nullable|numeric',
                'registration_date' => 'nullable',

            ]);


            //create registration data with Year and Month
            $personal_details['registration_period'] = date('Y');
            $personal_details['registration_month'] = date('m');

            //get employment status and residence details
            $personal_details['employment_status_id'] = request('employment_status_id');
            $personal_details['employment_location_id'] = request('employment_location_id');

            //get profession_id
            $profession_id = request('profession_id');
            $prefix = Prefix::whereProfession_id($profession_id)->first();
            //assign registration prefix
            $personal_details['prefix'] = $prefix->name;

            //Now create practitioner object
            $practitioner = Practitioner::create($personal_details);


            /*Get professional qualification details*/
            //check for qualification category, local = 1 and foreign = 2
            $professional_details['profession_id'] = $profession_id;

            $professional_details['qualification_category_id'] = request('qualification_category_id');
            if (request('qualification_category_id') == 1) {

                $professional_details['professional_qualification_id'] = request('professional_qualification_id');
                $professional_details['accredited_institution_id'] = request('accredited_institution_id');
            }

            if (request('qualification_category_id') == 2) {
                $professional_details['professional_qualification_name'] = request('professional_qualification_name');
                $professional_details['institution'] = request('institution');

            }
            $professional_details['commencement_date'] = request('commencement_date');
            $professional_details['completion_date'] = request('completion_date');

            //save professional qualification
            $add_qualification = $practitioner->addPractitionerQualification($professional_details);

            //Save contact and save email
            $add_contact = $practitioner->addContact
            (
                request(['email', 'primary_phone', 'physical_address'])
            );


            //at this stage there is no register category
            /*$practitioner_payment_information['register_category_id'] = request('register_category_id');
            $practitioner->addPractitionerPaymentInformation($practitioner_payment_information);*/

            /** get all requirements to create shortfalls */
            if ($practitioner->qualification_category_id == 1) {
                $requirements = Requirement::whereNotIn('group', ['foreigners'])->get();
            } else {
                $requirements = Requirement::all();
            }

            foreach ($requirements as $requirement) {
                $requirements_arr = array(
                    "requirement_id" => $requirement->id,
                    "practitioner_id" => $practitioner->id
                );
                $practitioner->addPractitionerRequirements($requirements_arr);
            }

            if ($practitioner->practitionerRequirements) {
                $practitioner->practitionerRequirements;
            }

            return response()->json([
                'response_status' => 1,
                'message' => 'Application Submitted successful',
                'practitioner' => $practitioner
            ]);
        }
    }

    //Submit payment
    public function step_2()
    {
        $data = request()->validate([
            'practitioner_id' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'currency' => 'required',
            'payment_channel_id' => 'required',
            'payment_item_category_id' => 'required',
            'payment_item_id' => 'required',
            'period' => 'required',
            'rate' => 'required',
            'pop' => 'nullable',
            'reference' => 'nullable',
        ]);

        $practitioner = Practitioner::find($data['practitioner_id']);

        $pop = '';
        $status = 0;
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

        //check balance status
        if ($renewal_balance > 0) {
            $renewals['renewal_status_id'] = 3;
        } else {
            $renewals['renewal_status_id'] = 3;
        }
        //save renewal_balance in USD
        if ($data['currency'] == 1) {
            $renewal_balance = $renewal_balance;
        }
        if ($data['currency'] == 0) {
            $renewal_balance = $renewal_balance / $data['rate'];
        }

        //get Pop
        if (request()->hasfile('pop')) {
            //get the file field data and name field from form submission
            $file = request()->file('pop');

            //get file original name
            $name = $file->getClientOriginalName();

            //create a unique file name using the time variable plus the name
            $file_name = time() . $name;

            //upload the file to a directory in Public folder
            $pop = $file->move('pops', $file_name);
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
        $payments['payment_item_category_id'] = $data['payment_item_category_id'];
        $payments['payment_date'] = now();
        $payments['payment_item_id'] = $data['payment_item_id'];
        $payments['proof'] = $pop;

        $add_renewal_payment = $add_renewal->addPayments($payments);

        //update previous balances to 0
        if ($renewal_balance > 0) {
            if (count($practitioner->payments)) {
                foreach ($practitioner->payments as $existing_payment) {
                    if ($existing_payment->id != $add_renewal_payment->id) {
                        $existing_payment->update(['balance' => 0]);
                        $existing_payment->renewal->update(['balance' => 0]);
                        $existing_payment->renewal->update(['renewal_status_id' => 3]);
                    }
                }
            }
        } else {
            if (count($practitioner->payments)) {
                foreach ($practitioner->payments as $existing_payment) {
                    if ($existing_payment->id != $add_renewal_payment->id) {
                        $existing_payment->update(['balance' => 0]);
                        $existing_payment->renewal->update(['balance' => 0]);
                        $existing_payment->renewal->update(['renewal_status_id' => 3]);
                    }
                }
            }
        }
        if ($practitioner->practitionerRequirements) {
            foreach ($practitioner->practitionerRequirements as $practitionerRequirement) {
                $practitionerRequirement->requirement;
            }

        }

        return response()->json([
            'response_status' => 1,
            'message' => 'Application payment was successful. Your application id is: ' . $practitioner->id . '. Use this to follow up with Allied or to update any required documents by going on the website under My Application tab.',
            'practitioner' => $practitioner,
        ]);


    }

    //submit documents
    public function step_4()
    {
        $id = request('id');
        $practitioner_id = request('practitioner_id');
        $practitioner = Practitioner::where('id', $practitioner_id)->first();

        $practitioner_requirements = $practitioner->practitionerRequirements;

        $get_files = array();
        $get_file_names = array();
        $get_requirements = array();
        $file_name = '';

        if (request()->hasfile('file')) {

            $files = request()->file('file');
            //get the file field data and name field from form submission
            foreach ($files as $key => $file) {
                //get file original name
                $name = $file->getClientOriginalName();
                $just_name = pathinfo($name, PATHINFO_FILENAME);

                //create a unique file name using the time variable plus the name
                $file_name = $practitioner_id . time() . $name;
                $path = $file->move('practitioner_documents', $file_name);
                $get_files[] = $path;
                $get_file_names[$key] = $just_name;
            }

            //upload the file to a directory in Public folder
            foreach ($get_file_names as $id => $get_file_name) {
                $requirement = Requirement::where('name', $get_file_name)->first();
                if ($requirement != null) {
                    $get_requirements[$id] = $requirement;
                    $update = $practitioner_requirements->where('requirement_id', $requirement->id)->first();
                    if ($update->file != null) {
                        $old_path = $update->file;
                        if ($old_path != null) {
                            unlink($old_path);
                            $update->update([
                                'file' => $get_files[$id]
                            ]);
                        }
                    }
                    $update->update([
                        'file' => $get_files[$id]
                    ]);
                }
            }

        }

        /** at this stage, the application is sent to registrations*/
        $registration_officer = User::where('role_id', 4)->first();
        $registration_officer->notify(
            new ApplicationSubmitted($practitioner)
        );

        /** at this stage, the application is sent to accountant*/
        $accountant = User::where('role_id', 5)->first();
        $accountant->notify(
            new RegistrationPayment($practitioner)
        );

        if ($practitioner->contact) {
            $practitioner->contact;
        }

        return response()->json([
            'response_status' => 1,
            'message' => 'Application documents were successfully uploaded. Will let you know once verification process is complete. Your application id is:' . $practitioner->id . '. Use this to follow up with Allied or to update any required documents by going on the website under My Application tab.',
            'practitioner' => $practitioner,
        ]);
    }

    public function registration_fee()
    {
        $data = request()->validate([
            'practitioner_id' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'currency' => 'required',
            'payment_channel_id' => 'required',
            'payment_item_category_id' => 'required',
            'payment_item_id' => 'required',
            'period' => 'required',
            'rate' => 'required',
            'pop' => 'nullable',
            'reference' => 'nullable',
        ]);

        $practitioner = Practitioner::find($data['practitioner_id']);

        $pop = '';
        //get Pop
        if (request()->hasfile('pop')) {
            //get the file field data and name field from form submission
            $file = request()->file('pop');

            //get file original name
            $name = $file->getClientOriginalName();

            //create a unique file name using the time variable plus the name
            $file_name = time() . $name;

            //upload the file to a directory in Public folder
            $pop = $file->move('pops', $file_name);
        }
        $renewal_balance = $data['amount_invoiced'] - $data['amount_paid'];
        //check balance status
        if ($renewal_balance > 0) {
            $renewals['renewal_status_id'] = 3;
        } else {
            $renewals['renewal_status_id'] = 3;
        }
        //save renewal_balance in USD
        if ($data['currency'] == 1) {
            $renewal_balance = $renewal_balance;
        }
        if ($data['currency'] == 0) {
            $renewal_balance = $renewal_balance / $data['rate'];
        }
        $add_renewal = $practitioner->renewals->where('renewal_period_id', $data['period'])->first();
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
        $payments['payment_item_category_id'] = $data['payment_item_category_id'];
        $payments['payment_date'] = now();
        $payments['payment_item_id'] = $data['payment_item_id'];
        $payments['proof'] = $pop;

        $add_renewal_payment = $add_renewal->addPayments($payments);

        //update previous balances to 0
        if ($renewal_balance > 0) {
            if (count($practitioner->payments)) {
                foreach ($practitioner->payments as $existing_payment) {
                    if ($existing_payment->id != $add_renewal_payment->id) {
                        $existing_payment->update(['balance' => 0]);
                        $existing_payment->renewal->update(['balance' => 0]);
                        $existing_payment->renewal->update(['renewal_status_id' => 3]);
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

        $practitioner->update([
            'accountant' => 3
        ]);

        if ($practitioner->contact) {
            $practitioner->contact;
        }

        return response()->json([
            'response_status' => 0,
            'message' => 'Application payment was successful. Your application id is: ' . $practitioner->id . '. Use this to follow up with Allied or to update any required documents by going on the website under My Application tab.',
            'practitioner' => $practitioner,
        ]);
    }

    public function find_my_application()
    {
        $practitioner_id = request('practitioner');
        $practitioner = Practitioner::find($practitioner_id);

        if ($practitioner != null) {
            return response()->json([
                'response_status' => 1,
                'practitioner' => $practitioner,
            ]);
        } else {
            return response()->json([
                'response_status' => 1,
                'practitioner' => null,
            ]);
        }
    }

    public function my_application(Practitioner $practitioner)
    {

        $payment_fees = PaymentItem::whereIn('id', [1, 2])->get();

        foreach ($payment_fees as $payment_fee) {
            if ($payment_fee->paymentItemCategory) {
                $payment_fee->paymentItemCategory;
            }
        }
        if ($practitioner->payments) {
            $practitioner->payments;
        }

        if ($practitioner->practitionerQualifications) {
            foreach ($practitioner->practitionerQualifications as $practitionerQualification) {
                $practitionerQualification->professionalQualification;
                $practitionerQualification->profession;
                $practitionerQualification->qualificationCategory;
            }
        }

        if (
            $practitioner->registration_officer == 1
            && $practitioner->accountant == 1
            && $practitioner->member == 1
            && $practitioner->registrar == 0
        ) {
            $message = 'Application Approved, pending registration fee payment';
            $status = 1;
        }
        else
            if (
                $practitioner->registration_officer == 1
                && $practitioner->accountant == 3 // only put 3 if registration payment has not been approved
                && $practitioner->member == 1
                && $practitioner->registrar == 0
            ) {
                $message = 'Your registration payment is pending verification.';
                $status = 2;

            }else if (
                $practitioner->registration_officer == 2
                && $practitioner->accountant == 2
                && $practitioner->member == 1
                && $practitioner->registrar == 1
            ) {
                $message = 'Application Approved';
                $status = 2;

            } else {
                $message = 'Pending Verification.';
                $status = 0;
            }

        return response()->json([
            'response_status' => $status,
            'practitioner' => $practitioner,
            'message' => $message,
            'payment_fees' => $payment_fees,
            'rate' => Rate::find(1)->rate,
        ]);

    }

}
