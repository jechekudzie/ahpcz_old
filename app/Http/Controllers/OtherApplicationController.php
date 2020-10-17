<?php

namespace App\Http\Controllers;

use App\OtherApplication;
use App\PaymentItem;
use App\Practitioner;
use Illuminate\Http\Request;

class OtherApplicationController extends Controller
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
    public function create(Practitioner $practitioner)
    {
        //
        $payment_items = PaymentItem::all()->sortBy('name');
        return view('admin.practitioner_other_apps.create', compact('practitioner','payment_items'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        //
        $practitioner->addOtherApplications(request()->validate([
            'payment_item_id'=>['required'],
            'application_date'=>['required'],
        ]));

        return back()->with('message','Application created, you can upload supporting documents');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(OtherApplication $otherApplication)
    {
        //
        return view('admin.practitioner_other_apps.show', compact('otherApplication'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherApplication $otherApplication)
    {
        //
        $payment_items = PaymentItem::all()->sortBy('name');
        return view('admin.practitioner_other_apps.edit', compact('otherApplication','payment_items'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OtherApplication $otherApplication)
    {
        //
        $otherApplication->update(request()->validate([
            'payment_item_id'=>['required'],
            'application_date'=>['required']
        ]));
        return redirect('/admin/practitioners/'.$otherApplication->practitioner->id)->with('message','Application updated');
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
