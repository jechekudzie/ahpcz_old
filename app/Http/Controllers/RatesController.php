<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //fetch all rates
        $rates = Rate::all()->sortBy('name');
        return view('admin.rates.index',compact('rates'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.rates.create');

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

        Rate::create(request()->validate([
            'name' => ['required'],
            'rate'=>['required']
        ]));

        $message = "Rate added successfully.";
        return view('admin.rates.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
        return view('admin.rates.show',compact('rate'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        //
        return view('admin.rates.edit',compact('rate'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Rate $rate)
    {
        //
        //update the record with the ID provided
        $rate->update(request()->validate([
            'name' => ['required'],
            'rate'=>['required']
        ]));

        return redirect('/admin/renewal_fees')->with('message','Rate updated successfully.');



    }


    public function destroy(Rate $rate)
    {
        //
        $rate->delete();
        return redirect('/admin/renewal_fees')->with('message','Rate deleted successfully.');

    }
}
