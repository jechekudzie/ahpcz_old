<?php

namespace App\Http\Controllers;

use App\City;
use App\Document;
use App\DocumentCategory;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Gender;
use App\Http\Resources\PractitionerResource;
use App\Http\Resources\PractitionerResourceCollection;
use App\MaritalStatus;
use App\Nationality;
use App\Notifications\ApplicationSubmitted;
use App\PaymentMethod;
use App\Practitioner;
use App\PractitionerContact;
use App\PractitionerCpdpoint;
use App\Prefix;
use App\Profession;
use App\Province;
use App\QualificationCategory;
use App\RegisterCategory;
use App\RegistrationFee;
use App\Renewal;
use App\RenewalCategory;
use App\Requirement;
use App\Shortfall;
use App\Title;
use App\User;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class PractitionersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
     {
         $this->middleware('auth');

     }


    public function index(Request $request)
    {
        return view('admin.practitioners.index');


    }

    public function pendingApproval(Request $request)
    {
        return view('admin.practitioners.pendings');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $professions = Profession::whereNotIn('id', [19])->get()->sortBy('name');//skip profession 19
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        $employment_locations = EmploymentLocation::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');

        return view('admin.practitioners.create',
            compact('titles', 'genders',
                'professions', 'qualification_categories', 'employment_statuses',
                'employment_locations','register_categories'
            ));

    }

    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
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

            return back()->with('message', 'Practitioner already exists.');

        } else {
            $personal_details = request()->validate([
                'title_id' => ['nullable'],
                'gender_id' => ['required'],
                'first_name' => ['nullable'],
                'last_name' => ['nullable'],
                'previous_name' => ['nullable'],
/*                'id_number' => 'nullable|alpha_num', 'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/',*/
                'id_number' => 'nullable',
                'profession_id' => ['required'],
                'qualification_category_id' => ['nullable'],
                'professional_qualification_id' => ['nullable'],
                'commencement_date' => ['nullable'],
                'completion_date' => ['nullable'],
                'registration_number' => 'nullable|numeric',
                'registration_date' => 'nullable',

            ]
                /*[
                    'id_number.regex' => 'ID number should contain at least one character and one number',

                ]*/
            );

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
            $practitioner->addContact(request([
                'email',
            ]));

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

            /*$user = User::whereRole_id(4)->first();

            $user->notify(
                new ApplicationSubmitted($practitioner)
            );*/

            return redirect('/admin/practitioners/' . $practitioner->id);
        }
    }

    //For renewal
    public function createForRenew()
    {
        //
        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $professions = Profession::whereNotIn('id', [19])->get()->sortBy('name');
        $qualification_categories = QualificationCategory::all()->sortBy('name');


        return view('admin.practitioners.renew',
            compact('titles', 'genders',
                'professions', 'qualification_categories'
            ));

    }

    public function practitionerRenewStore(Request $request)
    {
        $check_id_number = request('id_number');
        $check_profession_id = request('profession_id');

        $check_existensce = Practitioner::whereId_numberAndProfession_id($check_id_number, $check_profession_id)->first();
        if ($check_existensce != null) {

            return back()->with('message', 'Practitioner already exists.');

        } else {
            $personal_details = request()->validate([
                'title_id' => ['required'],
                'gender_id' => ['required'],
                'first_name' => ['required'],
                'last_name' => ['required'],
                'previous_name' => ['nullable'],
                'id_number' => ['alpha_num', 'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/'],
                'profession_id' => ['required'],
                'registration_number' => 'nullable|numeric',
                'registration_date' => 'nullable',
            ],
                [
                    'id_number.regex' => 'ID number should contain at least one character and one number',

                ]
            );
            $personal_details['registration_period'] = date('Y');
            $personal_details['registration_month'] = date('m');

            //get profession_id
            $profession_id = request('profession_id');
            $prefix = Prefix::whereProfession_id($profession_id)->first();
            //assign registration prefix
            $personal_details['prefix'] = $prefix->name;

            $practitioner = Practitioner::create($personal_details);

            //also add and update the email field
            $practitioner->addContact(request([
                'email',
                'primary_phone',
            ]));

            /** get all requirements to create shortfalls */
            $requirements = Requirement::all();
            foreach ($requirements as $requirement) {
                $requirements_arr = array(
                    "requirement_id" => $requirement->id,
                    "practitioner_id" => $practitioner->id
                );
                $practitioner->addPractitionerRequirements($requirements_arr);
            }


            $practitioner->update([
                'approval_status' => 1,
                'registration_officer' => 2,
                'accountant' => 1,
                'member' => 1,
                'registrar' => 1
            ]);

            /* $user = User::whereRole_id(4)->first();

             $user->notify(
                 new ApplicationSubmitted($practitioner)
             );*/


            return redirect('/admin/practitioners/' . $practitioner->id);
        }
    }

    public function addShortfallRequirements(Practitioner $practitioner)
    {
        if (request('qualification_category_id') == 1) {
            request()->validate([
                'accredited_institution_id' => ['required']
            ]);
            $personal_details['accredited_institution_id'] = request('accredited_institution_id');
        }

        if (request('qualification_category_id') == 2) {
            request()->validate([
                'institution' => ['required']
            ]);

            $personal_details['institution'] = request('institution');

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

        return view('admin.practitioners.show', compact(
            'practitioner', 'educations', 'identifications', 'professionals',
            'internship', 'registration_fee', 'registration_fee', 'current_status','portal_activate','portal_de_activate'));
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
        if($practitioner->profession_id != $personal_details['profession_id']){
            $profession_id = $personal_details['profession_id'];
            $prefix = Prefix::whereProfession_id($profession_id)->first();
            //assign registration prefix
            $personal_details['prefix'] = $prefix->name;
            $practitioner->update(['registration_number' => null]);
        }else{
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
        return view('admin.practitioners.delete', compact('practitioner'));
    }

    public function destroy(Practitioner $practitioner)
    {
        //
        $practitioner->contact()->delete();
        $practitioner->practitionerQualification()->delete();
        $practitioner->documents()->delete();
        $practitioner->employer()->delete();
        $practitioner->practitionerExperience()->delete();
        $practitioner->renewals()->delete();
        $practitioner->cdPoints()->delete();
        $practitioner->payments()->delete();
        $practitioner->practitionerRequirements()->delete();
        $practitioner->otherApplications()->delete();
        $practitioner->delete();

        return redirect('/admin/practitioners')->with('message', 'Practitioner deleted successfully.');
    }

}

