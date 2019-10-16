<?php

namespace App\Http\Controllers;

use App\Profession;
use App\ProfessionalQualification;
use Illuminate\Http\Request;

class ProfessionalQualificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');
        return view('admin.professional_qualifications.create', compact('professions'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        ProfessionalQualification::create(request()->validate([
            'profession_id' => ['required'],
            'name' => ['required']
        ]));


        return redirect('/admin/professional_qualifications/create')->with('message', 'Professional Qualification added successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessionalQualification $professionalQualification)
    {
        //
        return view('admin.professional_qualifications.show', compact('professionalQualification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionalQualification $professionalQualification)
    {
        //
        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');
        return view('admin.professional_qualifications.edit',
            compact('professionalQualification', 'professions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfessionalQualification $professionalQualification)
    {
        //
        $professionalQualification->update(request()->validate([

            'profession_id' => ['required'],
            'name' => ['required']

        ]));

        return redirect('/admin/accredited_institutions')->with('message', 'Professional Qualification updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionalQualification $professionalQualification)
    {
        //

        $professionalQualification->accreditation()->delete();

        $professionalQualification->delete();
        return redirect('/admin/accredited_institutions')->with('message', 'Professional Qualification deleted successfully.');

    }
}
