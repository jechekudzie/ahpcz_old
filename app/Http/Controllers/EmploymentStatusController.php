<?php

namespace App\Http\Controllers;

use App\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //fetch all employment_statuses
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        return view('admin.employment_statuses.index',compact('employment_statuses'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.employment_statuses.create');

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

        EmploymentStatus::create(request()->validate([
            'name' => ['required']
        ]));

        $message = "EmploymentStatus added successfully.";
        return view('admin.employment_statuses.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EmploymentStatus $employmentStatus)
    {
        //
        return view('admin.employment_statuses.show',compact('employmentStatus'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmploymentStatus $employmentStatus)
    {
        //
        return view('admin.employment_statuses.edit',compact('employmentStatus'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmploymentStatus $employmentStatus)
    {
        //
        //update the record with the ID provided
        $employmentStatus->update(request()->validate([
            'name' => ['required']
        ]));

        return redirect('/admin/renewal_categories')->with('message','Employment Status updated successfully.');



    }


    public function destroy(EmploymentStatus $employmentStatus)
    {
        //
        $employmentStatus->delete();
        return redirect('/admin/employment_statuses')->with('message','Employment Status deleted successfully.');

    }
}
