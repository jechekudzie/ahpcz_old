<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\PractitionerEmployer;
use App\PractitionerExperience;
use App\Province;
use Illuminate\Http\Request;

class PractitionerExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Practitioner $practitioner)
    {
        //
        $provinces = Province::all()->sortBy('name');

        return view('admin.practitioner_experience.create',
            compact('practitioner','provinces'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        //

        $test = $practitioner->addExperience(

            request()->validate([
                'name' => ['required'],
                'email' => ['required','email'],
                'phone' => ['required'],
                'business_address' => ['required'],
                'province_id' => ['required'],
                'city_id' => ['required'],
                'contact_person' => ['nullable'],
                'job_title' => ['required'],
                'commencement_date' => ['required'],
                'resignation_date' => ['required']
            ])
        );

        dd($test);

        return back()->with('message','Practitioner Experience added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(PractitionerExperience $practitionerExperience)
    {
        //
        return view('admin.practitioner_experience.show',compact('practitionerExperience'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PractitionerExperience $practitionerExperience)
    {
        //
        $provinces = Province::all()->sortBy('name');

        return view('admin.practitioner_experience.edit',
            compact('practitionerExperience','provinces'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PractitionerExperience $practitionerExperience)
    {
        //
        $practitionerExperience->update(

            request()->validate([
                'name' => ['required'],
                'email' => ['required','email'],
                'phone' => ['required'],
                'business_address' => ['required'],
                'province_id' => ['required'],
                'city_id' => ['required'],
                'contact_person' => ['nullable'],
                'job_title' => ['required'],
                'commencement_date' => ['required'],
                'resignation_date' => ['required']
            ])
        );

        return redirect('/admin/practitioners/experience/'.$practitionerExperience->id.'/show')->with('message','Practitioner experience updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
