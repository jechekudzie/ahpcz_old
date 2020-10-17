<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\PractitionerContact;
use App\Province;
use Illuminate\Http\Request;

class PractitionerContactsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Practitioner $practitioner)
    {
        $provinces = Province::all()->sortBy('name');
        return view('admin.practitioner_contacts.create', compact('practitioner', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {

        $practitioner->addContact(

            request()->validate([
                'physical_address' => ['required'],
                'email' => ['required'],
                'primary_phone' => ['required'],
                'secondary_phone' => ['nullable'],
                'province_id' => ['required'],
                'city_id' => ['required']
            ])
        );

        return redirect('/admin/practitioners/'.$practitioner->id)->with('message', 'Contact details added successfully');
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
    public function edit(Practitioner $practitioner)
    {
        //
        $provinces = Province::all()->sortBy('name');

        return view('admin.practitioner_contacts.edit', compact('practitioner', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PractitionerContact $practitionerContact)
    {
        $practitionerContact->update(request()->validate([
            'physical_address' => ['nullable'],
            'email' => ['nullable'],
            'primary_phone' => ['nullable'],
            'secondary_phone' => ['nullable'],
            'province_id' => ['nullable'],
            'city_id' => ['nullable']
        ]));


        //return back();
        return redirect('/admin/practitioners/' . $practitionerContact->practitioner_id)->with('message', 'Contact details updated successfully!');

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
