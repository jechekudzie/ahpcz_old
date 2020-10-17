<?php

namespace App\Http\Controllers;

use App\RenewalStatus;
use Illuminate\Http\Request;

class RenewalStatusesController extends Controller
{


    public function index()
    {
        //
        $renewal_statuses = RenewalStatus::all()->sortBy('name');
        return view('admin.renewal_statuses.index',compact('renewal_statuses'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.renewal_statuses.create');

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

        RenewalStatus::create(request()->validate([
            'name' => ['required'],
            'description' => ['required', 'min:10']
        ]));

        $message = "Renewal status added successfully.";
        return view('admin.renewal_statuses.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RenewalStatus $renewalStatus)
    {
        //
        return view('admin.renewal_statuses.show',compact('renewalStatus'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RenewalStatus $renewalStatus)
    {
        //
        return view('admin.renewal_statuses.edit',compact('renewalStatus'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RenewalStatus $renewalStatus)
    {
        //
        //update the record with the ID provided
        $renewalStatus->update(request()->validate([
            'name' => ['required'],
            'description' => ['required','min:10']
        ]));

        return redirect('/admin/renewal_statuses')->with('message','Renewal status updated successfully.');



    }


    public function destroy(RenewalStatus $renewalStatus)
    {
        //
        $renewalStatus->delete();
        return redirect('/admin/renewal_statuses')->with('message','Renewal status deleted successfully.');

    }


}
