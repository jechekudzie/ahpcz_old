<?php

namespace App\Http\Controllers;

use App\StudentRegistrationFee;
use Illuminate\Http\Request;

class StudentRegistrationFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $student_registration_fees = StudentRegistrationFee::all();
        return view('admin.student_registration_fees.index', compact('student_registration_fees'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentRegistrationFee $student_registration_fee)
    {
        //
        return view('admin.student_registration_fees.edit', compact('student_registration_fee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRegistrationFee $student_registration_fee )
    {
        //
        $student_registration_fee->update(request()->validate([
            'fee' => ['required','numeric']
        ]));

        return redirect('/admin/student_registration_fees')->with('message','Student registration fees updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
