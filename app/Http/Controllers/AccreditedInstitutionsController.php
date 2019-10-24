<?php

namespace App\Http\Controllers;


use App\Accreditation;
use App\AccreditedInstitution;
use App\DiscreditedInstitution;
use App\ProfessionalQualification;
use Illuminate\Http\Request;

class AccreditedInstitutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   /* public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function index()
    {
        //display anything to doo with accreditation
        $professionalQualifications = ProfessionalQualification::all()->sortBy('name');
        $accredited_qualifications = Accreditation::all()->sortBy('id');
        $accredited_institutions = AccreditedInstitution::all()->sortBy('name');
        $discredited_institutions = DiscreditedInstitution::all()->sortBy('name');
        return view('admin.accredited_institutions.index', compact(
            'accredited_institutions', 'accredited_qualifications',
            'professionalQualifications', 'discredited_institutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.accredited_institutions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        AccreditedInstitution::create(request()->validate([
            'name' => ['required']
        ]));


        return redirect('admin/accredited_institutions/create')->with('message','Institution added successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(AccreditedInstitution $accreditedInstitution)
    {
        //
        return view('admin.accredited_institutions.show', compact('accreditedInstitution'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AccreditedInstitution $accreditedInstitution)
    {
        //
        return view('admin.accredited_institutions.edit', compact('accreditedInstitution'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccreditedInstitution $accreditedInstitution)
    {
        //
        $accreditedInstitution->update(request()->validate([
            'name' => ['required']
        ]));
        return redirect('/admin/accredited_institutions')->with('message', 'Institution updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccreditedInstitution $accreditedInstitution)
    {
        //
        $accreditedInstitution->accreditation()->delete();
        $accreditedInstitution->delete();
        return redirect('/admin/accredited_institutions')->with('message', 'Institution deleted successfully.');

    }
}
