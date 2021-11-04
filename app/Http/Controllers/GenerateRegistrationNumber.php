<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\Prefix;
use App\Profession;
use App\StudentNumber;
use Illuminate\Http\Request;

class GenerateRegistrationNumber extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($profession_id, Practitioner $practitioner)
    {
        $prefix = Prefix::whereProfession_id($profession_id)->first();
        $registration_number = $prefix->last_reg + 1;

        $registration_number = sprintf("%04d", $registration_number);

        $practitioner->update([
            'registration_number' => $registration_number,
        ]);

        $prefix->update([
            'last_reg' => $registration_number,
        ]);

        return back()->with('message', 'Registration number generated successfully');


    }


    public function student_create(Practitioner $practitioner)
    {
        $data = StudentNumber::where('renewal_period_id', date('Y'))->first();
        if ($data != null) {
            $student_number = $data->student_number + 1;
            $student_number = sprintf("%04d", $student_number);

            $full_number = 'A/S'.substr($data->renewal_period_id,-2).$student_number;

            $practitioner->update([
                'student_number' => $full_number
            ]);
            $data->update([
                'student_number' => $student_number
            ]);
        }else{
            $data = StudentNumber::create([
                'renewal_period_id' => date('Y'),
                'student_number'=> 0
            ]);
            $student_number = $data->student_number + 1;
            $student_number = sprintf("%04d", $student_number);

            $full_number = 'A/S'.substr($data->renewal_period_id,-2).$student_number;

            $practitioner->update([
                'student_number' => $full_number
            ]);

            $data->update([
                'student_number' => $student_number
            ]);
        }

        return back()->with('message', 'Student registration number generated successfully');


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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
