<?php

namespace App\Http\Controllers;

use App\PaymentItem;
use App\PaymentItemRequirement;
use Illuminate\Http\Request;

class PaymentItemRequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentItem $paymentItem)
    {
        //
        if($paymentItem->payment_item_requirements){
            $payment_item_requirements = $paymentItem->payment_item_requirements;
        }
        return view('admin.payment_item_requirements.index',
            compact('payment_item_requirements','paymentItem'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PaymentItem $paymentItem)
    {
        //
        return view('admin.payment_item_requirements.create',compact('paymentItem'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentItem $paymentItem)
    {
        //
        $requirement = request()->validate(['requirement'=>'required']);

        $payment_item_requirement = $paymentItem->add_payment_item_requirements($requirement);

         return back()->with('message',$payment_item_requirement->requirement. ' Created successfully');
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
    public function edit(PaymentItemRequirement $paymentItemRequirement)
    {
        //
        return view('admin.payment_item_requirements.edit',compact('paymentItemRequirement'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentItemRequirement $paymentItemRequirement)
    {
        //
        $paymentItemRequirement->update(request()->validate(['requirement'=>'required']));
        return back()->with('message','Update was successful');
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
