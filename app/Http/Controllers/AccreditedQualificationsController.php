<?php

namespace App\Http\Controllers;

use App\Accreditation;
use App\AccreditedInstitution;
use App\ProfessionalQualification;
use Illuminate\Http\Request;

class AccreditedQualificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {

        $accreditations = Accreditation::all()->sortBy('id');

        return view('admin.accredited_qualification.test', compact('accreditations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $professionalQualifications = ProfessionalQualification::all()->sortBy('name');
        $accredited_institutions = AccreditedInstitution::all()->sortBy('name');

        return view('admin.accredited_qualification.create', compact('professionalQualifications', 'accredited_institutions'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Accreditation::create(request()->validate([
            'professional_qualification_id' => ['required'],
            'accredited_institution_id' => ['required']
        ]));

        return redirect('/admin/accredited_qualifications/create')->with('message', 'Accredited added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($data)
    {
        $accreditation = Accreditation::find($data);

        $professionalQualifications = ProfessionalQualification::all()->sortBy('name');
        $accredited_institutions = AccreditedInstitution::all()->sortBy('name');

        return view('admin.accredited_qualification.edit', compact('accreditation', 'professionalQualifications', 'accredited_institutions'));

    }


    public function show($data){

        $accreditation = Accreditation::find($data);
        return view('admin.accredited_qualification.show', compact('accreditation'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($data)
    {
        $accreditation = Accreditation::find($data);

        $accreditation->update(request()->validate([
            'professional_qualification_id' => ['required'],
            'accredited_institution_id' => ['required']
        ]));

        return redirect('/admin/accredited_institutions')->with('message', 'Accredited Qualification updated successfully.');


    }


    public function destroy($data)
    {
        $accreditation = Accreditation::find($data);
        $accreditation->delete();
        return redirect('/admin/accredited_institutions')->with('message', 'Accredited Qualification deleted successfully.');

    }

}
