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
                'qualification_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        /*Get professional qualification details*/
        //check for qualification category, local = 1 and foreign = 2

        $professional_details  = request()->validate([
           'profession_id' =>'required',
           'qualification_category_id' =>'required',

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


        return redirect('/admin/practitioners/qualifications/' . $practitioner->id . '/create')->with('message', 'Practitioner qualification added successfully');


    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(PractitionerQualification $practitionerQualification)
    {

        return view('admin.practitioner_qualifications.show', compact('practitionerQualification'));
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

        //dd($practitionerQualification->professional_qualification_id);
        /*$professional_details  = request()->validate([
            'profession_id' =>'required',
            'qualification_category_id' =>'required',
        ]);*/

        if (request('qualification_category_id') == 1) {
            $professional_details = request()->validate([
                'professional_qualification_id' => ['required'],
                'accredited_institution_id' => ['required']

            ]);
            $practitionerQualification->update([
                'profession_id'=> request('profession_id'),
                'qualification_category_id'=> request('qualification_category_id'),
                'professional_qualification_id'=> request('professional_qualification_id'),
                'accredited_institution_id'=> request('accredited_institution_id'),

                //set these to null
                'professional_qualification_name'=> null,
                'institution'=> null,

                'commencement_date'=> request('commencement_date'),
                'completion_date'=> request('completion_date'),
            ]);


        }

        if (request('qualification_category_id') == 2) {
            $professional_details = request()->validate([
                'professional_qualification_name' => ['required'],
                'institution' => ['required'],
            ]);
            $practitionerQualification->update([
                'profession_id' => request('profession_id'),
                'qualification_category_id'=> request('qualification_category_id'),
                'professional_qualification_name' => request('professional_qualification_name'),
                'institution'=> request('institution'),

                //set these to null
                'professional_qualification_id'=> null,
                'accredited_institution_id'=> null,

                'commencement_date'=> request('commencement_date'),
                'completion_date'=> request('completion_date'),
            ]);

        }

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
