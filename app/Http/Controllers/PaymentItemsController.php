<?php

namespace App\Http\Controllers;

use App\PaymentItem;
use App\PaymentItemCategory;
use App\PaymentItemFee;
use Illuminate\Http\Request;

class PaymentItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        //

        $payment_items = PaymentItem::all()->sortBy('name');
        $payment_item_categories = PaymentItemCategory::all()->sortBy('name');

        return view('admin.payment_items.index',compact('payment_items','payment_item_fees','payment_item_categories'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $payment_item_categories = PaymentItemCategory::all()->sortBy('name');

        return view('admin.payment_items.create',compact('payment_item_categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        PaymentItem::create(request()->validate([
            'name'=>['required'],
            'payment_item_category_id'=>['required'],
            'fee'=>['required']
        ]));

        return back()->with('message','Payment item added successfully');

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
    public function edit(PaymentItem $paymentItem)
    {
        //
        $payment_item_categories = PaymentItemCategory::all()->sortBy('name');

        return view('admin.payment_items.edit',compact('paymentItem','payment_item_categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentItem $paymentItem)
    {
        //
        $paymentItem->update(request()->validate([
            'name'=>['required'],
            'payment_item_category_id'=>['required'],
            'fee'=>['required']
        ]));

        return redirect('/admin/payment_items')->with('message','Payment item updated successfully');

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
