<?php

namespace App\Http\Controllers;

use App\City;
use App\Document;
use App\DocumentCategory;
use App\Gender;
use App\MaritalStatus;
use App\Nationality;
use App\Notifications\ApplicationSubmitted;
use App\PaymentMethod;
use App\Practitioner;
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

    public function index()
    {


        $practitioners = Practitioner::whereApproval_status(1)->get()->sortBy('first_name');
        $pendings = Practitioner::whereApproval_status(0)->get()->sortBy('first_name');
        return view('admin.practitioners.index', compact('practitioners', 'pendings'));
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
        $professions = Profession::whereNotIn('id', [19])->get()->sortBy('name');
        $qualification_categories = QualificationCategory::all()->sortBy('name');


        return view('admin.practitioners.create',
            compact('titles', 'genders',
                'professions', 'qualification_categories'
            ));

    }

    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
    {
        $check_id_number = request('id_number');
        $check_profession_id = request('profession_id');

        $check_existensce = Practitioner::whereId_numberAndProfession_id($check_id_number,$check_profession_id)->first();
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
                'qualification_category_id' => ['required'],
                'professional_qualification_id' => ['required'],
                'commencement_date' => ['required'],
                'completion_date' => ['required'],
                'registration_number' => 'nullable|numeric',

            ],
                [
                    'id_number.regex' => 'ID number should contain at least one character and one number',

                ]
            );
            $personal_details['registration_period'] = date('Y');
            $personal_details['registration_month'] = date('m');

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

            //get profession_id
            $profession_id = request('profession_id');
            $prefix = Prefix::whereProfession_id($profession_id)->first();
            //assign registration prefix
            $personal_details['prefix'] = $prefix->name;

            $practitioner = Practitioner::create($personal_details);

            //also add and update the email field
            $practitioner->addContact(request([
                'email',
            ]));

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

            $user = User::whereRole_id(4)->first();

            $user->notify(
                new ApplicationSubmitted($practitioner)
            );

            return redirect('/admin/practitioners/' . $practitioner->id);
        }
    }


    //for renewal
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

        $check_existensce = Practitioner::whereId_numberAndProfession_id($check_id_number,$check_profession_id)->first();
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Practitioner $practitioner)
    {
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
            'internship', 'registration_fee', 'registration_fee', 'current_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Practitioner $practitioner)
    {

        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $marital_statuses = MaritalStatus::all()->sortBy('name');
        $provinces = Province::all()->sortBy('name');
        $nationalities = Nationality::all()->sortBy('name');
        $cities = City::all()->sortBy('name');
        $professions = Profession::whereNotIn('id', [19])->get()->sortBy('name');
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $payment_methods = PaymentMethod::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');

        return view('admin.practitioners.edit',
            compact('practitioner', 'titles', 'genders', 'marital_statuses',
                'provinces', 'cities', 'nationalities', 'professions',
                'qualification_categories', 'renewal_categories', 'payment_methods',
                'register_categories'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Practitioner $practitioner)
    {
        //update practitioner personal details
        $personal_details = request()->validate([
            'title_id' => ['required'],
            'gender_id' => ['required'],
            'id_number' => ['required', 'alpha_num'],

            'first_name' => ['required'],
            'last_name' => ['required'],
            'previous_name' => ['nullable'],
            'dob' => ['required'],


            'nationality_id' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],

            'profession_id' => ['required'],
            'professional_qualification_id' => ['required'],
            'qualification_category_id' => ['required'],

            'register_category_id' => ['required'],
            'renewal_category_id' => ['required'],
            'payment_method_id' => ['required'],
            'registration_number' => ['required'],

            'commencement_date' => ['required'],
            'completion_date' => ['required'],

        ]);


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

        $practitioner->update($personal_details);

        //redirect to dashboard
        return redirect('/admin/practitioners/' . $practitioner->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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

    public function other(Practitioner $practitioner)
    {
        //
        return view('admin.practitioners.other', compact('practitioner'));
    }
}

