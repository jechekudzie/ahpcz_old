<?php

namespace App\Http\Controllers;

use App\Notifications\ApplicationSubmitted;
use App\Notifications\FullPayment;
use App\Notifications\PartPayment;
use App\PaymentChannel;
use App\PaymentMethod;
use App\PaymentType;
use App\Practitioner;
use App\RegisterCategory;
use App\RegistrationFee;
use App\Renewal;
use App\RenewalCategory;
use App\RenewalPeriod;
use App\Vat;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function paymentsRequirementUpdate(Practitioner $practitioner)
    {
        $practitioner->update(request()->validate([
            'payment_method_id' => 'required',
            'renewal_category_id' => 'required',
            'register_category_id' => 'required',
        ]));

        /**here after updating the payment methods, check to see if this practitioner has
         * anything in renewals, if yes redirect to renewal checkStatus, if not go to registration route
         */

        if (count($practitioner->renewals)) {
            return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/checkPaymentStatusRegistration');
        }else{
            return redirect('/admin/practitioners/registration/' . $practitioner->id . '/registration');
        }

    }

    public function checkPaymentStatus(Practitioner $practitioner)
    {

        if (count($practitioner->payments)) {
            $chikwereti = $practitioner->payments->sum('balance');
            if ($chikwereti > 0) {
                return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/invoiceBalances');
            } else {
                return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/invoiceRenewal');
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Practitioner $practitioner)
    {
        //it will only redirect if practitioner already have something in renewals table
        $count = count($practitioner->renewals);
        if ($count > 0) {
            return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/checkPaymentStatusRegistration');
        }

        //if above condition is not met, it will fetch the create file
        $qualification_category_id = $practitioner->qualificationCategory->id;
        $registration_fee = RegistrationFee::where('qualification_category_id', $qualification_category_id)->first();
        $vat = Vat::where('id', 1)->first();
        $payment_types = PaymentType::all()->sortBy('name');
        $payment_channels = PaymentChannel::all();
        $renewal_periods = RenewalPeriod::all()->sortByDesc('period');

        //get items for practitioner payment requirement update
        $payment_methods = PaymentMethod::all()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');
        return view('admin.practitioner_payments.registration', compact(
            'practitioner', 'payment_channels', 'payment_types',
            'renewal_periods', 'registration_fee', 'payment_methods',
            'renewal_categories', 'register_categories', 'vat'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {

        $payment = request()->validate([
            'payment_date' => 'required',
            'renewal_period_id' => 'required',
            'payment_channel_id' => 'required',
            'amount_paid' => 'required',
            'receipt_number' => ['required','digits_between:4,8','numeric','unique:payments'],
            'pop' => 'nullable',
        ]);

        /** @var  $registration_fee */
        //set values
        //registration fees
        $registration_fee = RegistrationFee::where('qualification_category_id', $practitioner->qualificationCategory->id)->first();
        /** @var  $renewal_period_id */
        $renewal_period_id = request('renewal_period_id');
        /** calculate @var  $renewal_balance */
        /*$renewal_balance = $registration_fee->fee - request('amount_paid');*/
        $renewal_balance = request('amount_invoiced') - request('amount_paid');
        /** add attributes to renewal */
        $renewals['renewal_period_id'] = request('renewal_period_id');
        $renewals['payment_method_id'] = $practitioner->payment_method_id;
        $renewals['renewal_category_id'] = $practitioner->renewal_category_id;
        $renewals['payment_type_id'] = 2;//registration type
        $renewals['balance'] = $renewal_balance;

        /** check renewal balance to update status either paid or owing @var $renewal_balance */
        if ($renewal_balance > 0) {

            $renewals['renewal_status_id'] = 3;

        } else {
            $renewals['renewal_status_id'] = 1;
        }

        /**check if a profession for this practitioner has cd points, if not update with one
         * else update later when they provide cpd points */

        $cdpoints = $practitioner->profession->cdpoint;

        if ($cdpoints->points <= 0) {
            $renewals['cdpoints'] = 1;
        }

        /**check if renewal with the same renewal period/year already exist with the same practitioner*/
        $check_renewal = Renewal::whereRenewal_period_idAndPractitioner_id($renewal_period_id, $practitioner->id)->first();
        /**/
        if ($check_renewal == null) {
            /*$registration = $practitioner->addRegistration($renewals);*/
            $renewal = $practitioner->addRenewal($renewals);
            $month = date('m');
            $day = date('d');



            $payment['month'] = $month;
            $payment['day'] = $day;
            /*$payment['amount_invoiced'] = $registration_fee->fee;*/
            $payment['amount_invoiced'] = request('amount_invoiced');
            $payment['balance'] = $renewal_balance;
            $payment['practitioner_id'] = $practitioner->id;
            $payment['payment_item_category_id'] = 2;
            $payment['payment_item_id'] = 34;
            $renewal->addPayments($payment);

            return redirect('/admin/practitioners/' . $practitioner->id)->with('message', 'Payment completed successfully.');

        } else {

            return back()->with('message', 'A renewal subscription for the selected period is already active, not that if this a regular payment click the payment link to proceed');

        }

    }

}
