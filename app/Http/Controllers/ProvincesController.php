<?php

namespace App\Http\Controllers;

use App\Province;
use Illuminate\Http\Request;

class ProvincesController extends Controller
{

    public function index()
    {
        
        //fetch all provinces
        $provinces = Province::all()->sortBy('name');
        return view('admin.provinces.index',compact('provinces'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.provinces.create');

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

        Province::create(request()->validate([
            'name' => ['required']
        ]));

        $message = "Province added successfully.";
        return view('admin.provinces.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        //
        return view('admin.provinces.show',compact('province'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        //
        return view('admin.provinces.edit',compact('province'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Province $province)
    {
        //
        //update the record with the ID provided
        $province->update(request()->validate([
            'name' => ['required']
        ]));

        return redirect('/admin/provinces')->with('message','Province updated successfully.');



    }


    public function destroy(Province $province)
    {
        //
        $province->delete();
        return redirect('/admin/provinces')->with('message','Province deleted successfully.');

    }



}
