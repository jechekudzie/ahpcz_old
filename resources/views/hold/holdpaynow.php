<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

use Paynow\Payments\Paynow;

class PaynowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function makePayment()
    {
        $attributes = request()->validate([
            'amount' => ['required'],
            'transaction_id' => ['required']
        ]);
        $amount = request('amount');
        $id = request('transaction_id');
        //instantiate paynow object
        $paynow = new Paynow
        (
            '5865',
            '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
            'http://localhost:8000/paynow/' . $id . '/checkPayment',
            'http://localhost:8000/paynow/' . $id . '/checkPayment'
        );
        //create a payment and add items required
        $payment = $paynow->createPayment($id, 'nigel@leadingdigital.africa');
        $payment->add('Bananas', $amount);
        //initiate payment
        $response = $paynow->send($payment);

        //check if initiation was a success
        if ($response->success()) {
            // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
            $make_payment_link = $response->redirectUrl();
            // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
            $pollUrl = $response->pollUrl();
            //create an array of data to be saved in the database
            $attributes['poll_url'] = $pollUrl;
            //save data
            Payment::create($attributes);
            return redirect($make_payment_link);
        }

    }

    public function checkPayment($id)
    {
        $paynow = new Paynow(
            '5865',
            '23962222-9610-4f7c-bbd5-7e12f19cdfc6',
            'http://localhost:8000/paynow/' . $id . '/checkPayment',
            'http://localhost:8000/paynow/' . $id . '/checkPayment'
        );
        $payment = Payment::where('transaction_id', $id)->first();
        $pollUrl = $payment->poll_url;
        $response = $paynow->pollTransaction($pollUrl);
        $status = $response->status();
        $paynowref = $response->paynowreference();
        return view('payments.success', compact('status','paynowref'));
    }

    public function result()
    {
        //
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('payments.create');
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
