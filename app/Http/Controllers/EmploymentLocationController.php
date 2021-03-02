<?php

namespace App\Http\Controllers;

use App\EmploymentLocation;
use Illuminate\Http\Request;

class EmploymentLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //fetch all employment_locations
        $employment_locations = EmploymentLocation::all()->sortBy('name');
        return view('admin.employment_locations.index',compact('employment_locations'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.employment_locations.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        EmploymentLocation::create(request()->validate([
            'name' => ['required']
        ]));

        $message = "EmploymentLocation added successfully.";
        return view('admin.employment_locations.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EmploymentLocation $employmentLocation)
    {
        //
        return view('admin.employment_locations.show',compact('employmentLocation'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmploymentLocation $employmentLocation)
    {
        //
        return view('admin.employment_locations.edit',compact('employmentLocation'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmploymentLocation $employmentLocation)
    {
        //
        //update the record with the ID provided
        $employmentLocation->update(request()->validate([
            'name' => ['required']
        ]));

        return redirect('/admin/renewal_categories')->with('message','Employment Location updated successfully.');



    }


    public function destroy(EmploymentLocation $employmentLocation)
    {
        //
        $employmentLocation->delete();
        return redirect('/admin/employment_locations')->with('message','EmploymentLocation deleted successfully.');

    }

}
