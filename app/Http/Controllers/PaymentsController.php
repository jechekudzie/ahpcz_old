<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentChannel;
use App\PaymentType;
use App\Practitioner;
use App\RegistrationFee;
use App\Renewal;
use App\RenewalPeriod;
use Illuminate\Http\Request;

class PaymentsController extends Controller
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

    public function index(Renewal $renewal)
    {

        return view('admin.practitioner_payments.index',compact('renewal'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Practitioner $practitioner)
    {
        $qualification_category_id = $practitioner->qualificationCategory->id;

        $registration_fee = RegistrationFee::where('qualification_category_id', $qualification_category_id)->first();


        $payment_types = PaymentType::all()->sortBy('name');
        $payment_channels = PaymentChannel::all();
        $renewal_periods = RenewalPeriod::all()->sortBy('period');
        return view('admin.practitioner_payments.create', compact(
            'practitioner', 'payment_channels', 'payment_types', 'renewal_periods','registration_fee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {



    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Renewal $renewal)
    {
        //
        return view('admin.practitioner_payments.show',compact('renewal'));
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
