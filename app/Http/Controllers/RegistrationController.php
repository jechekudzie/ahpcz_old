<?php

namespace App\Http\Controllers;

use App\Notifications\ApplicationSubmitted;
use App\Notifications\FullPayment;
use App\Notifications\PartPayment;
use App\PaymentChannel;
use App\PaymentItem;
use App\PaymentItemCategory;
use App\PaymentMethod;
use App\PaymentType;
use App\Practitioner;
use App\Rate;
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
        } else {
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

    public function paymentItemFee($payment_item_id)
    {
        $fee = PaymentItem::Where('id', $payment_item_id)->first();
        $response = "";
        $amount_invoiced = $fee->fee;
        $response .= $amount_invoiced;
        echo $response;
    }

    public function create(Practitioner $practitioner)
    {
        $rate = Rate::find(1);
        //$payment_items = PaymentItem::all()->sortBy('name');
        $payment_channels = PaymentChannel::all()->sortBy('name');
        $payment_item_categories = PaymentItemCategory::where('id', [2])->get()->sortBy('name');
        return view('admin.practitioner_payments.registration_payments',
            compact('practitioner', 'payment_channels',
                'rate', 'payment_item_categories')
        );
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
            'payment_item_category_id' => 'required',
            'payment_item_id' => 'required',
            'payment_channel_id' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'currency' => 'required',
            /* 'receipt_number' => ['required','digits_between:4,8','numeric','unique:payments'],*/
            'pop' => 'nullable',
        ]);
        $rate = Rate::find(1)->rate;
        $renewal_balance = 0;
        //zwl
        if($payment['currency'] == 0){
            $amount_invoiced = request('amount_invoiced') * $rate;
            $renewal_balance = $amount_invoiced - request('amount_paid') / $rate;
        }
        //usd
        if($payment['currency'] == 1){
            $amount_invoiced = $payment['amount_invoiced'];
            $renewal_balance = $amount_invoiced - request('amount_paid');
        }
        $payment['renewal_period_id'] = date('Y');
        /**check if renewal with the same renewal period/year already exist with the same practitioner*/
        $check_renewal = Renewal::where('renewal_period_id', date('Y'))
            ->where('practitioner_id', $practitioner->id)->first();
        if ($check_renewal == null) {
            $renewal = $practitioner->addRenewal([
                'payment_method_id' => 1,
                'renewal_category_id' => 1,
                'renewal_period_id' => date('Y'),
                'balance' => 0,
                'renewal_status_id' => 1,
                'payment_type_id' => 1,
                'cdpoints' => 1,
                'placement' => 1,
                'certificate_request' => 1,
                'certificate' => 0,
                'currency' => $payment['currency'],
                'renewal_criteria_id' => 1,
            ]);
            /*$registration = $practitioner->addRegistration($renewals);*/
            $month = date('m');
            $day = date('d');
            $payment['month'] = $month;
            $payment['day'] = $day;
            $payment['amount_invoiced'] = $amount_invoiced;
            $payment['amount_paid'] = request('amount_paid');
            $payment['balance'] = $renewal_balance;
            $payment['practitioner_id'] = $practitioner->id;
            $payment['payment_item_category_id'] = request('payment_item_category_id');
            $payment['payment_item_id'] = request('payment_item_id');
            $payment['payment_channel_id'] = request('payment_channel_id');
            $payment['rate'] =$rate;
            $new_renewal_payment = $renewal->addPayments($payment);

            if(request('payment_item_id') == 33 || request('payment_item_id') == 34){
                if ($renewal_balance > 0) {
                    if (count($practitioner->payments)) {
                        foreach ($practitioner->payments as $existing_payment) {
                            if ($existing_payment->id != $new_renewal_payment->id) {
                                $existing_payment->update(['balance' => 0]);
                                $existing_payment->renewal->update(['balance' => 0]);
                                $existing_payment->renewal->update(['renewal_status_id' => 1]);
                            }
                        }
                    }
                } else {
                    if (count($practitioner->payments)) {
                        foreach ($practitioner->payments as $existing_payment) {
                            if ($existing_payment->id != $new_renewal_payment->id) {
                                $existing_payment->update(['balance' => 0]);
                                $existing_payment->renewal->update(['balance' => 0]);
                                $existing_payment->renewal->update(['renewal_status_id' => 1]);
                            }
                        }
                    }

                }
            }

            return redirect('/admin/practitioners/' . $practitioner->id)->with('message', 'Registration Payment completed successfully.');

        } else {
            return back()->with('message', 'A renewal subscription for the selected period is already active, note that if this a regular payment click the payments link to proceed');
        }

    }

}
