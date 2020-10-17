<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function index()
    {
        //fetch all cities
        $cities = City::all()->sortBy('name');
        return view('admin.cities.index', compact('cities'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $provinces = Province::all()->sortBy('name');

        return view('admin.cities.create', compact('provinces'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        City::create(request()->validate([
            'province_id' => ['required'],
            'name' => ['required']
        ]));


        return redirect('/admin/cities/create')->with('message', 'City added successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
        return view('admin.cities.show', compact('city'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
        $provinces = Province::all()->sortBy('name');
        return view('admin.cities.edit', compact('city','provinces'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(City $city)
    {
        //
        //update the record with the ID provided
        $city->update(request()->validate([
            'province_id' => ['required'],
            'name' => ['required']
        ]));

        return redirect('/admin/cities')->with('message', 'City updated successfully.');


    }


    public function destroy(City $city)
    {
        //
        $city->delete();
        return redirect('/admin/cities')->with('message', 'City deleted successfully.');

    }


}
