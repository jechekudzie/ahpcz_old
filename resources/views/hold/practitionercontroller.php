<?php

namespace App\Http\Controllers;

use App\City;
use App\Gender;
use App\MaritalStatus;
use App\Nationality;
use App\PaymentMethod;
use App\Practitioner;
use App\Profession;
use App\Province;
use App\QualificationCategory;
use App\RenewalCategory;
use App\Title;
use Illuminate\Http\Request;

class PractitionersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $practitioners = Practitioner::all()->sortBy('first_name');
        return view('admin.practitioners.index',compact('practitioners'));
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
        $marital_statuses  = MaritalStatus::all()->sortBy('name');
        $provinces  = Province::all()->sortBy('name');
        $nationalities  = Nationality::all()->sortBy('name');
        $cities  = City::all()->sortBy('name');
        $professions  = Profession::all()->sortBy('name');
        $qualification_categories  = QualificationCategory::all()->sortBy('name');
        $renewal_categories  = RenewalCategory::all()->sortBy('name');
        $payment_methods  = PaymentMethod::all()->sortBy('name');

        return view('admin.practitioners.create',
            compact('titles','genders','marital_statuses','provinces','cities','nationalities',
                'professions','qualification_categories','renewal_categories','payment_methods'
            ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $personal_details = request()->validate([
            'title_id' => ['required'],
            'gender_id' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'previous_name'=>['nullable'],
            'dob'=>['required'],
            'id_number'=>['required'],
            'marital_status_id'=>['required'],
            'profession_id'=>['required'],
            'qualification_category_id'=>['required'],
            'renewal_category_id'=>['required'],
            'payment_method_id'=>['required'],
            'nationality_id'=>['required'],
            'province_id'=>['required'],
            'city_id'=>['required'],
        ]);

        $personal_details['registration_period'] = date('Y');
        $personal_details['registration_month'] = date('m');

        $practitioner = Practitioner::create($personal_details);

        return redirect('/admin/practitioners/'.$practitioner->id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Practitioner $practitioner)
    {
        //
        return view('admin.practitioners.show',compact('practitioner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Practitioner $practitioner)
    {
        //
        $titles = Title::all()->sortBy('name');
        $genders = Gender::all()->sortBy('name');
        $marital_statuses  = MaritalStatus::all()->sortBy('name');
        $provinces  = Province::all()->sortBy('name');
        $nationalities  = Nationality::all()->sortBy('name');
        $cities  = City::all()->sortBy('name');
        $professions  = Profession::all()->sortBy('name');
        $qualification_categories  = QualificationCategory::all()->sortBy('name');
        $renewal_categories  = RenewalCategory::all()->sortBy('name');
        $payment_methods  = PaymentMethod::all()->sortBy('name');

        return view('admin.practitioners.edit',
            compact('practitioner','titles','genders','marital_statuses','provinces','cities','nationalities',
                'professions','qualification_categories','renewal_categories','payment_methods'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Practitioner $practitioner)
    {
        //update practitioner personal details

        $practitioner->update(request()->validate([
            'title_id' => ['required'],
            'gender_id' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'previous_name'=>['nullable'],
            'dob'=>['required'],
            'id_number'=>['required'],
            'marital_status_id'=>['required'],
            'profession_id'=>['required'],
            'qualification_category_id'=>['required'],
            'renewal_category_id'=>['required'],
            'payment_method_id'=>['required'],
            'nationality_id'=>['required'],
            'province_id'=>['required'],
            'city_id'=>['required']
        ]));

        //redirect to dashboard
        return redirect('/admin/practitioners/'.$practitioner->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function other(Practitioner $practitioner)
    {
        //
        return view('admin.practitioners.other',compact('practitioner'));
    }
}
