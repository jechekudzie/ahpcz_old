<?php

namespace App\Http\Controllers;

use App\EmploymentLocation;
use App\EmploymentStatus;
use App\RenewalCategory;
use App\RenewalCriteria;
use Illuminate\Http\Request;

class RenewalCriteriaController extends Controller
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
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        $employment_locations = EmploymentLocation::all()->sortBy('name');

        return view('admin.renewal_criteria.create',
            compact('renewal_categories','employment_statuses','employment_locations'));

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
        $renewal_criteria = request()->validate([
            'renewal_category_id'=>'required',
            'employment_status_id'=>'required',
            'employment_location_id'=>'required',
            'certificate_request'=>'required',
            'percentage'=>'required|numeric',
        ],[
            'renewal_category_id.required'=>'please choose renewal category.',
            'employment_status_id.required'=>'please choose  employment status.',
            'employment_location_id.required'=>'please choose residence.',
            'certificate_request.required'=>'please choose certificate issuing request.',
            'percentage.required.numeric'=>'please choose certificate issuing request.',
        ]);

        RenewalCriteria::create($renewal_criteria);

        return back()->with('message','Renewal criteria added successfully!');
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
    public function edit(RenewalCriteria $renewalCriteria)
    {
        //
        //dd($renewalCriteria);

        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        $employment_locations = EmploymentLocation::all()->sortBy('name');

        return view('admin.renewal_criteria.edit',
            compact('renewal_categories','renewalCriteria',
                'employment_statuses','employment_locations'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RenewalCriteria $renewalCriteria)
    {
        //

        $renewal_criteria = request()->validate([
            'renewal_category_id'=>'required',
            'employment_status_id'=>'required',
            'employment_location_id'=>'required',
            'certificate_request'=>'required',
            'percentage'=>'required|numeric',
        ],[
            'renewal_category_id.required'=>'please choose renewal category.',
            'employment_status_id.required'=>'please choose  employment status.',
            'employment_location_id.required'=>'please choose residence.',
            'certificate_request.required'=>'please choose certificate issuing request.',
            'percentage.required.numeric'=>'please choose certificate issuing request.',
        ]);

        $renewalCriteria->update($renewal_criteria);

        return redirect('/admin/renewal_categories')->with('message','Renewal criteria updated successfully!');
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
