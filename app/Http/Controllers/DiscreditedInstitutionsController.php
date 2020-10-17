<?php

namespace App\Http\Controllers;

use App\DiscreditedInstitution;
use Illuminate\Http\Request;

class DiscreditedInstitutionsController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.discredited_institutions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        DiscreditedInstitution::create(request()->validate([
            'name' => ['required']
        ]));


        return redirect('admin/discredited_institutions/create')->with('message','Discredited Institution added successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DiscreditedInstitution $discreditedInstitution)
    {
        //
        return view('admin.discredited_institutions.show',compact('discreditedInstitution'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscreditedInstitution $discreditedInstitution)
    {
        //
        return view('admin.discredited_institutions.edit',compact('discreditedInstitution'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscreditedInstitution $discreditedInstitution)
    {
        //
        $discreditedInstitution->update(request()->validate([
            'name' => ['required']
        ]));
        return redirect('/admin/accredited_institutions')->with('message','Discredited Institution updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscreditedInstitution $discreditedInstitution)
    {

        $discreditedInstitution->delete();
        return redirect('/admin/accredited_institutions')->with('message','Discredited Institution deleted successfully.');

    }

}
