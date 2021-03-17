<?php

namespace App\Http\Controllers;

use App\City;
use App\CpdCriteria;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Gender;
use App\PaymentChannel;
use App\Practitioner;
use App\Prefix;
use App\Profession;
use App\Province;
use App\QualificationCategory;
use App\Rate;
use App\RegisterCategory;
use App\Renewal;
use App\RenewalCriteria;
use App\Title;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class PortalApiController extends Controller
{
    public function make_payment()
    {
        $practitioner_id = request('practitioner_id');
        $practitioner = Practitioner::find($practitioner_id);


        $data = request()->validate([
            'period' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'receipt_number' => ['required', 'digits_between:4,8', 'numeric', 'unique:payments'],
            'payment_date' => 'required',
            'payment_channel_id' => 'required',
            'currency' => 'required',
            'pop' => 'nullable',

            'points' => 'required',
            'file' => 'nullable',

            'dob' => 'required',
            'employment_status_id' => 'required',
            'employment_location_id' => 'required',
            'certificate_request' => 'required',

            'practitioner_id' => 'required',
            'renewal_category_id' => 'required',
            'cpd_criteria' => 'required',
            'renewal_criteria_id' => 'required',
            'rate' => 'required',

        ]);

        $practitioner->update([
            'employment_status_id' => $data['employment_status_id'],
            'employment_location_id' => $data['employment_location_id'],
            'dob' => $data['dob'],
        ]);



        //first step check to see if the amount invoice was full paid or there is a balance
        $renewal_balance = $data['amount_invoiced'] - $data['amount_paid'];

        $renewals['renewal_period_id'] = $data['period'];
        $renewals['practitioner_id'] = $practitioner->id;
        $renewals['payment_method_id'] = 1;
        $renewals['renewal_category_id'] = $data['renewal_category_id'];
        $renewals['currency'] = $data['currency'];
        $renewals['balance'] = $renewal_balance;
        $renewals['payment_type_id'] = 1; //a renewal payment type
        $renewals['certificate_request'] = $data['certificate_request'];
        $renewals['placement'] = 1;
        $renewals['renewal_criteria_id'] = $data['renewal_criteria_id'];

        if ($renewal_balance > 0) {
            $renewals['renewal_status_id'] = 3;
        } else {
            $renewals['renewal_status_id'] = 1;
        }

        if ($data['points'] >= $data['cpd_criteria']) {
            $renewals['cdpoints'] = 1;
            $cpd_points['practitioner_id'] = $practitioner->id;
            $cpd_points['renewal_period_id'] = $data['period'];
            $cpd_points['points'] = $data['points'];
            $practitioner->addCdPoints($cpd_points);
        } else {
            $renewals['cdpoints'] = 0;
        }

        //now check if the practitioner already for this current year
        if (Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            return response()->json([
                'message',
                'A renewal subscription for the selected period is already active,
                not that if this a regular payment click the payment link to proceed']);
        }
        else {

            $add_renewal = $practitioner->addRenewal($renewals);
            $payments['renewal_period_id'] = $data['period'];
            $payments['renewal_id'] = $add_renewal->id;
            $payments['month'] = date('m');
            $payments['day'] = date('d');
            $payments['practitioner_id'] = $practitioner->id;
            $payments['balance'] = $renewal_balance;
            $payments['amount_invoiced'] = $data['amount_invoiced'];
            $payments['amount_paid'] = $data['amount_paid'];
            $payments['payment_channel_id'] = $data['payment_channel_id'];
            $payments['rate'] = $data['rate'];
            $payments['currency'] = $data['currency'];
            $payments['receipt_number'] = $data['receipt_number'];
            $payments['payment_item_category_id'] = 1;
            $payments['payment_date'] = $data['payment_date'];
            $payments['payment_item_id'] = 33;

            $add_renewal_payment = $add_renewal->addPayments($payments);

            //update previous balances to 0
            if ($renewal_balance > 0) {
                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            } else {

                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }

            }
            return response()->json([
                'message' => 'Your Payment  was successful',
            ]);


        }
    }
}
