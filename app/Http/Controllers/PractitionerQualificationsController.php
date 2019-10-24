<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\PractitionerQualification;
use App\Profession;
use App\Province;
use App\QualificationCategory;
use Illuminate\Http\Request;

class PractitionerQualificationsController extends Controller
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
        /*  $practitioner = Practitioner::find($id);*/
        $professions = Profession::whereId($practitioner->profession_id)->get();
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        return view('admin.practitioner_qualifications.create',
            compact('practitioner', 'professions',
                'qualification_categories','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        $practitioner->addPractitionerQualification(

            request()->validate([
                'profession_id' => ['required'],
                'qualification_category_id' => ['required'],
                'professional_qualification_id' => ['required'],
                'accredited_institution_id' => ['nullable'],
                'institution' => ['nullable'],
                'commencement_date' => ['required'],
                'completion_date' => ['required']
            ]));

        return redirect('/admin/practitioners/qualifications/' . $practitioner->id . '/create')->with('message', 'Practitioner qualification added successfully');


    }

    public function storePrimary(Practitioner $practitioner)
    {

            $practitioner->update(request()->validate([
                'profession_id' => ['required'],
                'qualification_category_id' => ['required'],
                'professional_qualification_id' => ['required'],
                'accredited_institution_id' => ['nullable'],
                'institution' => ['nullable'],
                'commencement_date' => ['required'],
                'completion_date' => ['required']
            ]));

        return redirect('/admin/practitioners/' . $practitioner->id )->with('message', 'Practitioner qualification updated successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(PractitionerQualification $practitionerQualification)
    {
        //
        //dd($practitionerQualification->qualification_category_id);
        return view('admin.practitioner_qualifications.show', compact('practitionerQualification'));
    }

    public function showPrimary(Practitioner $practitioner)
    {
        //
        //dd($practitionerQualification->qualification_category_id);
        return view('admin.practitioner_qualifications.show_primary', compact('practitioner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PractitionerQualification $practitionerQualification)
    {
        //

        $professions = Profession::all()->sortBy('name');
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        return view('admin.practitioner_qualifications.edit', compact('practitionerQualification', 'professions', 'qualification_categories'));

    }

    public function editPrimary(Practitioner $practitioner)
    {
        $professions = Profession::all()->sortBy('name');
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        return view('admin.practitioner_qualifications.edit_primary', compact('practitioner', 'professions', 'qualification_categories'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PractitionerQualification $practitionerQualification)
    {
        //

        $practitionerQualification->update(request()->validate([
            'profession_id' => ['required'],
            'qualification_category_id' => ['required'],
            'professional_qualification_id' => ['required'],
            'accredited_institution_id' => ['nullable'],
            'institution' => ['nullable'],
            'commencement_date' => ['required'],
            'completion_date' => ['required']
        ]));
        return redirect('/admin/practitioners/' . $practitionerQualification->practitioner->id )->with('message', 'Practitioner qualification updated successfully');


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
