<?php

namespace App\Http\Controllers;

use App\QualificationCategory;
use App\RegistrationFee;
use Illuminate\Http\Request;

class RegistrationFeesController extends Controller
{

    public function index()
    {
        //fetch all registration_fees
        $registration_fees = RegistrationFee::all()->sortBy('name');
        return view('admin.registration_fees.index', compact('registration_fees'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $qualification_categories = QualificationCategory::all()->sortBy('name');

        return view('admin.registration_fees.create', compact('qualification_categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        RegistrationFee::create(request()->validate([
            'qualification_category_id' => ['required'],
            'fee' => ['required','numeric']
        ]));


        return redirect('/admin/registration_fees/create')->with('message', 'Registration Fee added successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(RegistrationFee $registrationFee)
    {
        //
        return view('admin.registration_fees.show', compact('registrationFee'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistrationFee $registrationFee)
    {
        //
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        return view('admin.registration_fees.edit', compact('registrationFee','qualification_categories'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegistrationFee $registrationFee)
    {
        //
        //update the record with the ID provided
        $registrationFee->update(request()->validate([
            'qualification_category_id' => ['required'],
            'fee' => ['required','numeric']
        ]));

        return redirect('/admin/registration_fees')->with('message', 'Registration fee updated successfully.');


    }


    public function destroy(RegistrationFee $registrationFee)
    {
        //
        $registrationFee->delete();
        return redirect('/admin/registration_fees')->with('message', 'Registration fee deleted successfully.');

    }



}
