<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use App\Practitioner;
use App\RegisterCategory;
use App\RenewalCategory;
use Illuminate\Http\Request;

class PractitionerPaymentInfoController extends Controller
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
        $payment_methods = PaymentMethod::all()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');
        return view('admin.practitioner_payment_info.create', compact('payment_methods', 'renewal_categories', 'register_categories', 'practitioner'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        //
        if ($practitioner->practitioner_payment_information){
            $practitioner->practitioner_payment_information->update(request()->validate([
                'payment_method_id' => 'required',
                'renewal_category_id' => 'required',
                'register_category_id' => 'required',
            ]));
        }else{
            $practitioner->practitioner_payment_information()->create(request()->validate([
                'payment_method_id' => 'required',
                'renewal_category_id' => 'required',
                'register_category_id' => 'required',
            ]));
        }


        return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
