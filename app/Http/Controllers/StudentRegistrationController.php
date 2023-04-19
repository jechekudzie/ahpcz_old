<?php

namespace App\Http\Controllers;

use App\Document;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Gender;
use App\Nationality;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\RegistrationPayment;
use App\Notifications\StudentSubmission;
use App\Practitioner;
use App\Prefix;
use App\Profession;
use App\QualificationCategory;
use App\RegisterCategory;
use App\RegistrationFee;
use App\Renewal;
use App\Requirement;
use App\Title;
use App\User;
use Illuminate\Http\Request;

class StudentRegistrationController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        return view('admin.students.index');
    }

    public function create()
    {
        //
        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $professions = Profession::whereNotIn('id', [19])->get()->sortBy('name');//skip profession 19
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        $employment_locations = EmploymentLocation::all()->sortBy('name');
        $register_categories = RegisterCategory::where('id',1)->get();

        return view('admin.students.create',
            compact('titles', 'genders',
                'professions', 'qualification_categories', 'employment_statuses',
                'employment_locations', 'register_categories'
            ));

    }

    public function store(Request $request)
    {
        //first check if id/passport number and profession is available
        request()->validate([
            'id_number' => 'nullable',
            'profession_id' => 'required',
        ]);
        $check_id_number = request('id_number');
        $check_profession_id = request('profession_id');

        $check_existensce = Practitioner::where('id_number', $check_id_number)
            ->where('profession_id', $check_profession_id)->first();

        //if the practitioner exists display message
        if ($check_existensce != null) {
            return back()->with('message', 'Practitioner already exists.');

        } else {
            $personal_details = request()->validate([
                    'title_id' => ['nullable'],
                    'gender_id' => ['required'],
                    'first_name' => ['nullable'],
                    'last_name' => ['nullable'],
                    'id_number' => 'nullable|alpha_num', 'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/',
                    'profession_id' => ['required'],
                    'qualification_category_id' => ['nullable'],
                    'professional_qualification_id' => ['nullable'],
                    'commencement_date' => ['nullable'],
                    'completion_date' => ['nullable'],
                    'registration_date' => 'nullable',

                ]
            );

            //create registration data with Year and Month
            $personal_details['registration_period'] = date('Y');
            $personal_details['registration_month'] = date('m');

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
                request()->validate([
                    'professional_qualification_id' => ['required'],
                    'accredited_institution_id' => ['required']
                ]);
                $professional_details['professional_qualification_id'] = request('professional_qualification_id');
                $professional_details['accredited_institution_id'] = request('accredited_institution_id');
            }

            if (request('qualification_category_id') == 2) {
                request()->validate([
                    'professional_qualification_name' => ['nullable'],
                    'institution' => ['nullable'],
                ]);

                $professional_details['professional_qualification_name'] = request('professional_qualification_name');
                $professional_details['institution'] = request('institution');

            }
            $professional_details['commencement_date'] = request('commencement_date');
            $professional_details['completion_date'] = request('completion_date');

            //save professional qualification
            $practitioner->addPractitionerQualification($professional_details);

            //Save contact and save email
            $practitioner->addContact
            (
                request(['email','primary_phone','physical_address'])
            );

            $practitioner_payment_information['register_category_id'] = request('register_category_id');
            $practitioner->addPractitionerPaymentInformation($practitioner_payment_information);

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

            $approval = array(
                'registration_officer'=>0,
                'accountant'=>0,
                'member'=>0,
                'registrar'=>0,
            );
            $practitioner->addStudentApprovals($approval);


            /** at this stage, the application is sent to registrations*/
            $registration_officer = User::where('role_id', 4)->first();
            if($registration_officer){
                $comment = 'New Student Application has been submitted, check and verify the application';
                $registration_officer->notify(
                    new StudentSubmission($practitioner,$comment)
                );
            }


            /** at this stage, the application is sent to accountant*/
           $accountant = User::where('role_id', 5)->first();
            if($accountant) {
                $comment = 'New Student Application has been submitted, record payment or verify if a payment has already been made.';
                $accountant->notify(
                    new StudentSubmission($practitioner,$comment)
                );
            }
            //dd($practitioner);
            return redirect('/admin/students/' . $practitioner->id);
        }
    }

    public function show(Practitioner $practitioner)
    {
        $portal_activate = 0;
        $portal_de_activate = 1;
        $registration_fee = 0;

        //$qualification_category_id = $practitioner->qualificationCategory->id;
        $registration_fee = RegistrationFee::where('qualification_category_id', 0)->first();


        $educations = Document::whereIn('document_category_id', [1, 2, 3, 4, 17, 18, 12, 13, 14, 15, 16])->get();

        $identifications = Document::whereIn('document_category_id', [5, 6, 7])->get();

        $professionals = Document::whereIn('document_category_id', [8, 9, 10, 11])->get();

        $internship = Document::whereIn('document_category_id', [])->get();

        $current_status = "";
        $year = date('Y');
        if (count($practitioner->renewals)) {
            $current_renewal = Renewal::wherePractitioner_idAndRenewal_period_id($practitioner->id, $year)->first();
            if ($current_renewal) {
                if ($current_renewal->renewal_status_id == 1) {
                    $current_status = 'Renewed';
                } elseif ($current_renewal->renewal_status_id == 2) {
                    $current_status = 'Part Payment';
                } elseif ($current_renewal->renewal_status_id == 3) {
                    $current_status = 'Owing';
                } else {
                    $current_status = 'Owing';
                }
            }

        } else {
            $current_status = 'Pending Registration Payment';
        }

        if ($practitioner->applications) {
            $applications = $practitioner->applications;
        }

        /*foreach ($applications as $application){
           dd( $application->payment_item->name);
        }*/


        return view('admin.students.show', compact(
            'practitioner', 'educations', 'identifications', 'professionals',
            'internship', 'registration_fee', 'registration_fee',
            'current_status', 'portal_activate', 'portal_de_activate', 'applications'));
    }


    public function edit(Practitioner $practitioner)
    {

        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');
        $nationalities = Nationality::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        $employment_locations = EmploymentLocation::all()->sortBy('name');
        $professions = Profession::all()->sortBy('name');
        return view('admin.practitioners.edit',
            compact('practitioner', 'titles', 'genders', 'nationalities',
                'register_categories', 'employment_statuses', 'employment_locations',
                'professions'
            ));
    }

    public function update(Practitioner $practitioner)
    {
        //update practitioner personal details
        $personal_details = request()->validate([
            'title_id' => 'nullable',
            'gender_id' => ['nullable'],
            'id_number' => ['nullable'],

            'first_name' => ['nullable'],
            'last_name' => ['nullable'],
            'previous_name' => ['nullable'],
            'dob' => ['nullable'],
            'nationality_id' => ['nullable'],
            'profession_id' => 'required',
            'employment_status_id' => 'required',
            'employment_location_id' => 'required',
            'registration_date' => 'nullable',
            'commencement_date' => ['nullable'],
            'completion_date' => ['nullable'],

        ]);

        //get profession_id
        if ($practitioner->profession_id != $personal_details['profession_id']) {
            $profession_id = $personal_details['profession_id'];
            $prefix = Prefix::whereProfession_id($profession_id)->first();
            //assign registration prefix
            $personal_details['prefix'] = $prefix->name;
            $practitioner->update(['registration_number' => null]);
        } else {
            $personal_details['registration_number'] = request('registration_number');
        }

        //update practitioner personal details
        $practitioner->update($personal_details);

        //validate register category to required
        $register_category_id = request()->validate([
            'register_category_id' => 'required',
        ]);

        //check to see if practitioner has any payment information recorded
        if ($practitioner->practitioner_payment_information) {
            $practitioner_payment_information['register_category_id'] = request('register_category_id');
            $practitioner->practitioner_payment_information->update($practitioner_payment_information);

        } else {
            $practitioner_payment_information['register_category_id'] = request('register_category_id');
            $practitioner->addPractitionerPaymentInformation($practitioner_payment_information);

        }
        //redirect to dashboard
        return redirect('/admin/practitioners/' . $practitioner->id);
    }

    public function delete(Practitioner $practitioner)
    {
        //
        return view('admin.students.delete', compact('practitioner'));
    }

    public function destroy(Practitioner $practitioner)
    {
        //
        $practitioner->contact()->delete();
        $practitioner->practitionerQualifications()->delete();
        $practitioner->documents()->delete();
        $practitioner->employer()->delete();
        $practitioner->practitioner_payment_information()->delete();
        $practitioner->renewals()->delete();
        $practitioner->cdPoints()->delete();
        $practitioner->payments()->delete();
        $practitioner->practitionerRequirements()->delete();
        $practitioner->otherApplications()->delete();
        $practitioner->delete();

        return redirect('/admin/students')->with('message', 'Student deleted successfully.');
    }



}
