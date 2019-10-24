<?php

namespace App\Http\Controllers;

use App\Document;
use App\Practitioner;
use App\PractitionerEmployer;
use App\Province;
use Exception;
use foo\bar;
use Illuminate\Http\Request;

class PractitionerEmployerController extends Controller
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

        return view('admin.practitioner_employers.create',compact('practitioner','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        try {
            $practitioner->addEmployer(

                request()->validate([
                    'name' => ['required'],
                    'email' => ['required','email'],
                    'phone' => ['required'],
                    'business_address' => ['required'],
                    'province_id' => ['required'],
                    'city_id' => ['required'],
                    'contact_person' => ['nullable'],
                    'job_title' => ['required'],
                    'commencement_date' => ['required']
                ])
            );
            return redirect('/admin/practitioners/'.$practitioner->id)->with('message','Employer added successfully');
        }catch (Exception $exception){

            return redirect('/admin/practitioners/'.$practitioner->id)->with('message','Practitioner already have an employer assigned');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PractitionerEmployer $practitionerEmployer)
    {
        $provinces = Province::all()->sortBy('name');

        return view('admin.practitioner_employers.edit',compact('practitionerEmployer','provinces'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PractitionerEmployer $practitionerEmployer)
    {
        $practitionerEmployer->update(

                request()->validate([
                    'name' => ['required'],
                    'email' => ['required','email'],
                    'phone' => ['required'],
                    'business_address' => ['required'],
                    'province_id' => ['required'],
                    'city_id' => ['required'],
                    'contact_person' => ['nullable'],
                    'job_title' => ['required'],
                    'commencement_date' => ['required']
                ])
            );
            return redirect('/admin/practitioners/'.$practitionerEmployer->practitioner->id)->with('message','Employer updated successfully');
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
}
