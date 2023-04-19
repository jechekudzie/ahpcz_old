<?php

namespace App\Http\Controllers;

use App\Profession;
use App\Rate;
use App\Tire;
use Illuminate\Http\Request;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //fetch all tires
        $tires = Tire::all()->sortBy('name');
        return view('admin.tires.index',compact('tires'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tires.create');

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

        Tire::create(request()->validate([
            'name' => ['required'],
            'fee'=>['required']
        ]));

        $message = "Tire added successfully.";
        return view('admin.tires.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tire $tire)
    {
        //

        $professions = Profession::all()->sortBy('name');
        $rates = Rate::all()->sortBy('name');
        return view('admin.tires.show',compact('tire','professions','rates'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tire $tire)
    {
        //
        return view('admin.tires.edit',compact('tire'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tire $tire)
    {
        //
        //update the record with the ID provided
        $tire->update(request()->validate([
            'name' => ['required'],
            'fee'=>['required']
        ]));

        return redirect('/admin/renewal_fees')->with('message','Tire updated successfully.');



    }


    public function destroy(Tire $tire)
    {
        //
        $tire->delete();
        return redirect('/admin/renewal_fees')->with('message','Tire deleted successfully.');

    }

}
