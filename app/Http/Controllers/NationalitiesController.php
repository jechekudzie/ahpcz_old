<?php

namespace App\Http\Controllers;

use App\Nationality;

use Illuminate\Http\Request;

class NationalitiesController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        //fetch all nationalities
        $nationalities = Nationality::all()->sortBy('name');
        return view('admin.nationalities.index',compact('nationalities'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.nationalities.create');

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


        Nationality::create(request()->validate([
            'code' => ['required'],
            'name' => ['required']
        ]));


        $message = "Nationality added successfully.";
        return view('admin.nationalities.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Nationality $nationality)
    {
        //
        return view('admin.nationalities.show',compact('nationality'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Nationality $nationality)
    {
        //
        return view('admin.nationalities.edit',compact('nationality'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Nationality $nationality)
    {
        //
        //update the record with the ID provided
        $nationality->update(request()->validate([
            'code' => ['required'],
            'name' => ['required']
        ]));

        return redirect('/admin/nationalities')->with('message','Nationality updated successfully.');



    }


    public function destroy(Nationality $nationality)
    {
        //
        $nationality->delete();
        return redirect('/admin/nationalities')->with('message','Nationality deleted successfully.');

    }



}
