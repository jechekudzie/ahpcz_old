<?php

namespace App\Http\Controllers;

use App\OperationalStatus;
use Illuminate\Http\Request;

class OperationalStatusesController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        //
        $operational_statuses = OperationalStatus::all()->sortBy('name');
        return view('admin.operational_statuses.index',compact('operational_statuses'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.operational_statuses.create');

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

        OperationalStatus::create(request()->validate([
            'name' => ['required'],
            'description' => ['required', 'min:10']
        ]));

        $message = "Operational status added successfully.";
        return view('admin.operational_statuses.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OperationalStatus $operationalStatus)
    {
        //
        return view('admin.operational_statuses.show',compact('operationalStatus'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OperationalStatus $operationalStatus)
    {
        //
        return view('admin.operational_statuses.edit',compact('operationalStatus'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OperationalStatus $operationalStatus)
    {
        //
        //update the record with the ID provided
        $operationalStatus->update(request()->validate([
            'name' => ['required'],
            'description' => ['required','min:10']
        ]));

        return redirect('/admin/operational_statuses')->with('message','Operational status updated successfully.');



    }


    public function destroy(OperationalStatus $operationalStatus)
    {
        //
        $operationalStatus->delete();
        return redirect('/admin/operational_statuses')->with('message','Operational status deleted successfully.');

    }

}
