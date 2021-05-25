<?php

namespace App\Http\Controllers;

use App\CertificateNumber;
use App\CpdCriteria;
use App\Mail\RenewalPayment;
use App\Mail\SignOff;
use App\Notifications\FullPayment;
use App\Notifications\PartPayment;
use App\Payment;
use App\PaymentChannel;
use App\PaymentItem;
use App\PaymentItemCategory;
use App\PaymentMethod;
use App\PaymentType;
use App\Practitioner;
use App\PractitionerCpdpoint;
use App\PractitionerPlacement;
use App\Rate;
use App\Registration;
use App\RegistrationFee;
use App\Renewal;
use App\RenewalCategory;
use App\RenewalCriteria;
use App\RenewalFee;
use App\RenewalPeriod;
use App\Vat;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Paynow\Payments\Paynow;
use File;

class RenewalController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth');
    }*/
    public function sessions()
    {
        $renewals = Renewal::all();
        foreach ($renewals as $renewal){
            $renewal->update([
                'balance' => 0
            ]);
        }
        dd(Session::get('payment'));
    }

    //Paynow response from paynow
    public function check_payment($practitioner_id)
    {
        $practitioner = Practitioner::where('id', $practitioner_id)->first();
        $payment = Session::get('payment');
        $data = $payment;
        $path = $payment['temp'];
        $currency = $payment['currency'];
        $file = Storage::path($path);
        //$file = fopen($file, 'r');
        $path = '';
        $status = 0;
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

        //now check if the practitioner already for this current year
        if (Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            return back()->with(
                'message',
                'A renewal subscription for the selected period is already active,
                not that if this a regular payment click the payment link to proceed');
        } else {
            $status = 1;
            if ($data['currency'] == 1) {
                $renewal_balance = $renewal_balance;
            }
            if ($data['currency'] == 0) {
                $renewal_balance = $renewal_balance / $data['rate'];
            }
            //add cpd points
            if ($file) {
                //upload the file to a directory in Public folder
                $storageName = basename($file);
                File::move($file, public_path('cpdpoints/' . $storageName));
                $path = 'cpdpoints/' . $storageName;
            }
            if ($data['points'] >= $data['cpd_criteria']) {
                $renewals['cdpoints'] = 1;
                $cpd_points['practitioner_id'] = $practitioner->id;
                $cpd_points['renewal_period_id'] = $data['period'];
                $cpd_points['points'] = $data['points'];
                $cpd_points['path'] = $path;
                $practitioner->addCdPoints($cpd_points);
            } else {
                $renewals['cdpoints'] = 0;
            }
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
            $payments['payment_item_category_id'] = 1;
            $payments['payment_date'] = $data['payment_date'];
            $payments['payment_item_id'] = 33;
            $payments['pop'] = $path;

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
            return redirect()->with('message', 'Renewal Payment Was successful.');
        }
        if ($currency == 1) {
            $paynow = new Paynow
            (
            //usd account
                '11778',
                '02f69090-68e9-427b-9838-966385aa0541',
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id,
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id

            );
        }

        if ($currency == 0) {
            $paynow = new Paynow
            (
            //local account
                '11777',
                '739d23ae-f8c5-45e0-ac0a-a481f615c813',
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id,
                'http://portal.ahpcz.co.zw/check_payment/' . $practitioner_id
            );
        }

        $poll_url = $payment['poll_url'];
        $paynow_data = $paynow->pollTransaction($poll_url);
        $status = $paynow_data->status();
        $ref = $paynow_data->reference();
        $paynowref = $paynow_data->paynowreference();

        $data['status'] = $status;
        $data['reference'] = $ref;
        $data['paynowreference'] = $paynowref;


        if ($message->status == 1) {
            Mail::to('admin@ahpcz.co.zw')->send(new RenewalPayment($practitioner, $data));
        }
        return redirect('/dashboard_manager/' . $practitioner_id);

    }


    public function check_restoration_penalties(Practitioner $practitioner)
    {
        $rate = Rate::find(1);
        $cpd_criterias = CpdCriteria::all();
        $renewal_criterias = RenewalCriteria::all();

        $tire = $practitioner->profession->profession_tire->tire;
        $profession = $practitioner->profession;
        $current_period = date('Y');
        $current_month = date('m');

        $renewal_fee = 0;
        $cpd_points = 0;
        $restoration_penalty_fee = 0;
        $restoration_penalty_name = '';
        $restoration_penalty_cpd = 0;
        $restoration_penalty_charge = 0;
        $total = 0;
        $balance = 0;

        foreach ($cpd_criterias as $cpd_criteria) {
            if ($cpd_criteria->profession_id == $profession->id) {
                $cpd_points = $cpd_criteria->standard;
            }
        }

        if (count($practitioner->renewals)) {
            $renewals = $practitioner->renewals;
            $size = sizeof($renewals);
            $last_renewal_period = $renewals[$size - 1]->renewal_period_id;

            //calculate balances
            foreach ($practitioner->payments as $payment) {
                if ($payment->currency == 0) {
                    $total = ($total) + ($payment->balance / $rate->rate);
                }
                if ($payment->currency == 1) {
                    $total = $total + $payment->balance;
                }
            }
            $balance = $total;


            //check restoration or penalty
            $result = $current_period - $last_renewal_period;
            if ($result == 1 && $current_month > 06) {
                $restoration_penalty_name = 'Restoration current year';
                if ($tire->id == 1) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 1.397);
                    $restoration_penalty_charge = 1.397;
                }

                if ($tire->id == 2) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 1.657);
                    $restoration_penalty_charge = 1.657;
                }

                if ($tire->id == 3) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 1.2);
                    $restoration_penalty_charge = 1.2;
                }

            } elseif ($result == 2) {
                $restoration_penalty_name = 'Restoration level 1';
                if ($tire->id == 1) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 1.793);
                    $restoration_penalty_charge = 1.793;
                }

                if ($tire->id == 2) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 2.314);
                    $restoration_penalty_charge = 2.314;
                }
                $cpd_points = $cpd_points * 1.5;

                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);
                return view('confirm_restoration',
                    compact('practitioner', 'restoration_penalty_name', 'restoration_penalty_fee',
                        'cpd_points', 'balance', 'rate'));
            } elseif ($result >= 3 && $result <= 5) {
                $restoration_penalty_name = 'Restoration level 2';
                if ($tire->id == 1) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 2.172);
                    $restoration_penalty_charge = 2.172;
                }

                if ($tire->id == 2) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 2.971);
                    $restoration_penalty_charge = 2.971;
                }
                $cpd_points = $cpd_points * 2;
                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);
                return view('confirm_restoration',
                    compact('practitioner', 'restoration_penalty_name', 'restoration_penalty_fee',
                        'cpd_points', 'balance', 'rate'));
            } elseif ($result > 5) {
                $restoration_penalty_name = 'Restoration level 3';
                if ($tire->id == 1) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 2.569);
                    $restoration_penalty_charge = 2.569;
                }
                if ($tire->id == 2) {
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = ceil($renewal_fee * 3.6);
                    $restoration_penalty_charge = 3.6;
                }
                $cpd_points = $cpd_points * 3;
                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);
                return view('confirm_restoration',
                    compact('practitioner', 'restoration_penalty_name', 'restoration_penalty_fee',
                        'cpd_points', 'balance', 'rate'));
            } elseif ($result == 1) {
                if ($current_month == 04) {
                    $restoration_penalty_name = 'Penalty level 1 = 5%';
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = $renewal_fee * 0.05;
                    $restoration_penalty_charge = 0.05;
                    $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                    //return redirect('/create_renewal');
                    return view('renewals.create')->with([
                        'practitioner' => $practitioner,
                    ]);

                }
                if ($current_month == 05) {
                    $restoration_penalty_name = 'Penalty level 2 = 10%';
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = $renewal_fee * 0.10;
                    $restoration_penalty_charge = 0.10;
                    $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                    //return redirect('/create_renewal');
                    return view('renewals.create')->with([
                        'practitioner' => $practitioner,
                    ]);

                }
                if ($current_month == 06) {
                    $restoration_penalty_name = 'Penalty level 3 = 15%';
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $restoration_penalty_fee = $renewal_fee * 0.15;
                    $restoration_penalty_charge = 0.15;
                    $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                    //return redirect('/create_renewal');
                    return view('renewals.create')->with([
                        'practitioner' => $practitioner,
                    ]);

                }

            } else {
                $restoration_penalty_name = 'No restoration no penalty';
                $restoration_penalty_fee = 0;
                $restoration_penalty_charge = 0;
                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                //return redirect('/create_renewal');
                return view('renewals.create')->with([
                    'practitioner' => $practitioner,
                ]);
            }

        } else {
            return view('last_renewal_period', compact('practitioner'));
        }

    }

    public function manual_restoration_penalties(Practitioner $practitioner)
    {
        $period = request()->validate([
            'period' => 'required'
        ]);

        $rate = Rate::find(1);
        $cpd_criterias = CpdCriteria::all();
        $renewal_criterias = RenewalCriteria::all();

        $tire = $practitioner->profession->profession_tire->tire;
        $profession = $practitioner->profession;
        $current_period = date('Y');
        $current_month = date('m');

        $renewal_fee = 0;
        $cpd_points = 0;
        $restoration_penalty_fee = 0;
        $restoration_penalty_name = '';
        $restoration_penalty_cpd = 0;
        $restoration_penalty_charge = 0;
        $total = 0;
        $balance = 0;

        foreach ($cpd_criterias as $cpd_criteria) {
            if ($cpd_criteria->profession_id == $profession->id) {
                $cpd_points = $cpd_criteria->standard;
            }
        }

        //calculate balances
        foreach ($practitioner->payments as $payment) {
            if ($payment->currency == 0) {
                $total = ($total) + ($payment->balance / $rate->rate);
            }
            if ($payment->currency == 1) {
                $total = $total + $payment->balance;
            }
        }
        $balance = $total;


        //check restoration or penalty
        $last_renewal_period = $period['period'];
        $result = $current_period - $last_renewal_period;
        if ($result == 1 && $current_month > 06) {
            $restoration_penalty_name = 'Restoration current year';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 1.397);
                $restoration_penalty_charge = 1.397;
            }

            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 1.657);
                $restoration_penalty_charge = 1.657;
            }

            if ($tire->id == 3) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 1.2);
                $restoration_penalty_charge = 1.2;
            }

        } elseif ($result == 2) {
            $restoration_penalty_name = 'Restoration level 1';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 1.793);
                $restoration_penalty_charge = 1.793;
            }

            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 2.314);
                $restoration_penalty_charge = 2.314;
            }
            $cpd_points = $cpd_points * 1.5;

            $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);
            return view('confirm_restoration',
                compact('practitioner', 'restoration_penalty_name', 'restoration_penalty_fee',
                    'cpd_points', 'balance', 'rate'));
        } elseif ($result >= 3 && $result <= 5) {
            $restoration_penalty_name = 'Restoration level 2';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 2.172);
                $restoration_penalty_charge = 2.172;
            }

            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 2.971);
                $restoration_penalty_charge = 2.971;

                //dd($restoration_penalty_fee);
            }
            $cpd_points = $cpd_points * 2;
            $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

            return view('confirm_restoration',
                compact('practitioner', 'restoration_penalty_name', 'restoration_penalty_fee',
                    'cpd_points', 'balance', 'rate'));
        } elseif ($result > 5) {
            $restoration_penalty_name = 'Restoration level 3';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 2.569);
                $restoration_penalty_charge = 2.569;
            }
            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = ceil($renewal_fee * 3.6);
                $restoration_penalty_charge = 3.6;
            }
            $cpd_points = $cpd_points * 3;
            $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);
            return view('confirm_restoration',
                compact('practitioner', 'restoration_penalty_name', 'restoration_penalty_fee',
                    'cpd_points', 'balance', 'rate'));
        } elseif ($result == 1) {
            if ($current_month == 04) {
                $restoration_penalty_name = 'Penalty level 1 = 5%';
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = $renewal_fee * 0.05;
                $restoration_penalty_charge = 0.05;
                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                //return redirect('/create_renewal');
                return view('renewals.create')->with([
                    'practitioner' => $practitioner,
                ]);

            }
            if ($current_month == 05) {
                $restoration_penalty_name = 'Penalty level 2 = 10%';
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = $renewal_fee * 0.10;
                $restoration_penalty_charge = 0.10;
                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                //return redirect('/create_renewal');
                return view('renewals.create')->with([
                    'practitioner' => $practitioner,
                ]);

            }
            if ($current_month == 06) {
                $restoration_penalty_name = 'Penalty level 3 = 15%';
                $renewal_fee = ceil($tire->fee * 1.145);
                $restoration_penalty_fee = $renewal_fee * 0.15;
                $restoration_penalty_charge = 0.15;
                $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

                //return redirect('/create_renewal');
                return view('renewals.create')->with([
                    'practitioner' => $practitioner,
                ]);

            }

        } else {
            $restoration_penalty_name = 'No restoration no penalty';
            $restoration_penalty_fee = 0;
            $restoration_penalty_charge = 0;
            $this->store_restoration($restoration_penalty_name, $restoration_penalty_fee, $balance, $cpd_points, $rate, $restoration_penalty_charge);

            //return redirect('/create_renewal');
            return view('renewals.create')->with([
                'practitioner' => $practitioner,
            ]);

        }
        //dd(Session::get('restoration'));
        return redirect('/admin/practitioner_renewals/' . $practitioner->id . '/create');

    }

    //offline and online payment for restoration
    public function make_restoration_payment()
    {
        $practitioner_id = (int)request('practitioner_id');
        $practitioner = Practitioner::find($practitioner_id);
        $amount_paid = 0;
        $amount_invoiced = 0;
        $path = '';
        $status = 0;
        $data = request()->validate([
            /*'period' => 'required',*/
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'payment_date' => 'required',
            'payment_channel_id' => 'required',
            'currency' => 'required',
            'pop' => 'nullable',

            'points' => 'required',
            'file' => 'nullable',

            'practitioner_id' => 'required',
            'rate' => 'required',

            'cpd_criteria' => 'required',

        ]);

        $data['period'] = date('Y');

        //put paynow Logic here

        //first step check to see if the amount invoice was full paid or there is a balance
        $renewal_balance = $data['amount_invoiced'] - $data['amount_paid'];

        $renewals['renewal_period_id'] = $data['period'];
        $renewals['practitioner_id'] = $practitioner->id;
        $renewals['payment_method_id'] = 1;
        $renewals['renewal_category_id'] = 1;
        $renewals['currency'] = $data['currency'];
        $renewals['balance'] = $renewal_balance;
        $renewals['payment_type_id'] = 1; //a renewal payment type
        $renewals['certificate_request'] = 1;
        $renewals['placement'] = 1;
        $renewals['renewal_criteria_id'] = 1;

        if ($renewal_balance > 0) {
            $renewals['renewal_status_id'] = 3;
        } else {
            $renewals['renewal_status_id'] = 1;
        }
        //now check if the practitioner already for this current year
        if (Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            return back()->with('message', 'A renewal subscription for the selected period is already active.');
        } else {
            $status = 1;
            if ($data['currency'] == 1) {
                //if currency ZWL
                $renewal_balance = $renewal_balance;
                $amount_paid = $data['amount_paid'];
                $amount_invoiced = $data['amount_invoiced'];
            }
            if ($data['currency'] == 0) {
                //if currency ZWL
                $renewal_balance = $renewal_balance / $data['rate'];
                $amount_paid = $data['amount_paid'] * $data['rate'];
                $amount_invoiced = $data['amount_invoiced'] * $data['rate'];
            }

            //add cpd points
            if (request()->hasfile('file')) {
                //get the file field data and name field from form submission
                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('cpdpoints', $file_name);
            }

            if ($data['points'] >= $data['cpd_criteria']) {
                $renewals['cdpoints'] = 1;
                $cpd_points['practitioner_id'] = $practitioner->id;
                $cpd_points['renewal_period_id'] = $data['period'];
                $cpd_points['points'] = $data['points'];
                $cpd_points['path'] = $path;
                $practitioner->addCdPoints($cpd_points);
            } else {
                $renewals['cdpoints'] = 0;
            }

            $add_renewal = $practitioner->addRenewal($renewals);
            $payments['renewal_period_id'] = $data['period'];
            $payments['renewal_id'] = $add_renewal->id;
            $payments['month'] = date('m');
            $payments['day'] = date('d');
            $payments['practitioner_id'] = $practitioner->id;
            $payments['balance'] = $renewal_balance;
            $payments['amount_invoiced'] = $amount_invoiced;
            $payments['amount_paid'] = $amount_paid;
            $payments['payment_channel_id'] = $data['payment_channel_id'];
            $payments['rate'] = $data['rate'];
            $payments['currency'] = $data['currency'];
            $payments['payment_item_category_id'] = 1;
            $payments['payment_date'] = $data['payment_date'];
            $payments['payment_item_id'] = 33;
            $payments['pop'] = $path;

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

            return redirect('admin/practitioners/' . $practitioner_id)->with(
                'message', 'Renewal Payment was successful.');

        }
    }


    public function store_restoration(
        $restoration_penalty_name, $restoration_penalty_fee,
        $balance, $cpd_points, $rate, $restoration_penalty_charge)
    {
        $restoration = [
            'restoration_penalty_name' => $restoration_penalty_name,
            'restoration_penalty_fee' => $restoration_penalty_fee,
            'balance' => $balance,
            'cpd_points' => $cpd_points,
            'rate' => $rate,
            'restoration_penalty_charge' => $restoration_penalty_charge,
        ];
        Session::get('restoration');
        Session::forget('restoration');
        if (empty(session()->get('restoration'))) {
            session()->put('restoration', $restoration);
        }
    }


    //list all renewal yearly payments
    public function index(Renewal $renewal)
    {
        return view('admin.practitioner_payments.payments_list', compact('renewal'));
    }

    //Initial renewal payment
    public function create(Practitioner $practitioner)
    {
        //stage 1
        /**Check for practitioner payment information
         *renewal_category(which category do you belong to), register_category(which register do you belong to), payment_method(who is paying for you)
         */


        return view('renewals.create')->with([
            'practitioner' => $practitioner,
        ]);


    }

    //Store initial payment and create yearly subscription
    public function store(Practitioner $practitioner)
    {
        $payment = request()->validate([
            'payment_date' => 'required',
            'renewal_period_id' => 'required',
            'payment_channel_id' => 'required',
            'amount_paid' => 'required',
            'receipt_number' => ['required', 'digits_between:4,8', 'numeric', 'unique:payments'],
            'pop' => 'nullable',
        ]);

        /** get @var $renewal_fee */
        $renewal_fee = RenewalFee::where('renewal_category_id', '=', $practitioner->practitioner_payment_information->renewal_category_id, 'AND', 'profession_id', '=', $practitioner->profession_id)->first();

        /** get the renewal period @var $renewal_period_id */
        $renewal_period_id = request('renewal_period_id');

        /** calculate balance  @var $renewal_balance */
        /*$renewal_balance = $renewal_fee->fee - request('amount_paid');*/
        $renewal_balance = request('amount_invoiced') - request('amount_paid');

        /** add attributes to @var $renewals */
        $renewals['renewal_period_id'] = request('renewal_period_id');
        $renewals['payment_method_id'] = $practitioner->practitioner_payment_information->payment_method_id;
        $renewals['renewal_category_id'] = $practitioner->practitioner_payment_information->renewal_category_id;
        $renewals['balance'] = $renewal_balance;

        /** check renewal balance to update status either paid or owing @var $renewal_balance */
        if ($renewal_balance > 0) {

            $renewals['renewal_status_id'] = 3;

        } else {
            $renewals['renewal_status_id'] = 1;
        }

        $renewals['payment_type_id'] = 1;

        //temporarily update the placement, cpd points
        $renewals['cdpoints'] = 1;
        $renewals['placement'] = 1;

        $submitted_receipt_number = request('receipt_number');

        //check for receipt_number in payment before proceeding
        $receipt_number = Payment::whereReceipt_number($submitted_receipt_number)->first();

        if ($receipt_number) {
            return back()->with('message', 'Receipt number already taken');
        }

        /**check if renewal with the same renewal period/year already exist with the same practitioner*/
        $check_renewal = Renewal::whereRenewal_period_idAndPractitioner_id($renewal_period_id, $practitioner->id)->first();
        if ($check_renewal == null) {
            /** create registration */
            $renewal = $practitioner->addRenewal($renewals);
            $month = date('m');
            $day = date('d');

            //add attributes to payments
            $payment['month'] = $month;
            $payment['day'] = $day;
            $payment['practitioner_id'] = $practitioner->id;
            $payment['balance'] = $renewal_balance;
            /*$payment['amount_invoiced'] = $renewal_fee->fee;*/
            $payment['amount_invoiced'] = request('amount_invoiced');
            $payment['payment_item_category_id'] = 1;
            $payment['payment_item_id'] = 33;
            $new_renewal_payment = $renewal->addPayments($payment);

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

            //update approval statuses
            if (
                $practitioner->approval_status == 0 && $practitioner->registration_officer == 0
                && $practitioner->accountant == 0 && $practitioner->member == 0
                && $practitioner->registrar == 0) {
                $practitioner->update([
                    'approval_status' => 1,
                    'registration_officer' => 2,
                    'accountant' => 1,
                    'member' => 1,
                    'registrar' => 1
                ]);
            }


            $practitioner_requirements = $practitioner->practitionerRequirements;
            foreach ($practitioner_requirements as $practitioner_requirement) {

                $practitioner_requirement->update([
                    'status' => 1,
                    'member_status' => 1
                ]);

            }

            return redirect('/admin/practitioners/' . $practitioner->id)->with('message', 'Payment completed successfully.');

        } else {
            return back()->with('message',
                'A renewal subscription for the selected period is already active,
                not that if this a regular payment click the payment link to proceed');
        }
    }


    //Create renewal payments (fetch form)
    public function createPayment(Renewal $renewal)
    {
        $payment_items = PaymentItem::all()->sortBy('name');
        $payment_channels = PaymentChannel::all()->sortBy('name');
        $payment_item_categories = PaymentItemCategory::all()->sortBy('name');
        return view('admin.practitioner_payments.renewal_payments',
            compact('renewal', 'payment_items', 'payment_channels', 'payment_item_categories')
        );

    }

    //make and store renewals payments (store data)
    public function makePayment(Renewal $renewal)
    {
        $payment = request()->validate([

            'payment_channel_id' => ['required'],
            'amount_invoiced' => ['required'],
            'amount_paid' => ['required'],
            'payment_date' => ['required'],
            'receipt_number' => ['required', 'digits_between:4,8', 'numeric', 'unique:payments'],
            'payment_item_category_id' => 'required',
            'payment_item_id' => 'required',
            'pop' => 'nullable',
        ]);

        //get payment type
        $payment_item_id = request('payment_item_id');

        //assign month and day
        $month = date('m');
        $day = date('d');

        $balance = request('amount_invoiced') - request('amount_paid');
        $payment['month'] = $month;
        $payment['day'] = $day;
        $payment['renewal_period_id'] = $renewal->renewal_period_id;
        $payment['practitioner_id'] = $renewal->practitioner->id;
        $payment['balance'] = $balance;

        /** check if there is a payment with the same payment id
         * for that particular period for that practitioner */


        if ($payment_item_id != 33 && $payment_item_id != 34 && $balance > 0) {

            return back()->with('message', 'Please note that for the selected item, only full payment is allowed');
        }

        foreach ($renewal->payments as $payments) {
            if ($payments->balance > 0) {
                $payments->update(['balance' => 0]);
            }
        }

        $renewal->addPayments($payment);

        if ($balance <= 0) {
            $renewal->update([
                'renewal_status_id' => 1,
                'balance' => $balance
            ]);
        } else {
            $renewal->update([
                'renewal_status_id' => 3,
                'balance' => $balance
            ]);
        }

        return redirect('/admin/practitioner_renewals/' . $renewal->id . '/index')->with('message', 'Payment was successful.');
    }


    public function practitionerBalances(Practitioner $practitioner)
    {
        $balances = Payment::wherePractitioner_id($practitioner->id)
            ->Where('balance', '>', 0)->get();

        return view('admin.practitioner_payments.balances', compact('balances', 'practitioner'));
    }


    //verify renewals
    public function initiate_renewal_verification(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        return view('admin.practitioner_payments.initiate_renewal_verification', compact('renewal', 'practitioner'));
    }

    public function initiate_renewal_sign_off(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        return view('admin.practitioner_payments.initiate_renewal_sign_off', compact('renewal', 'practitioner'));
    }

    public function verify_renewal(Renewal $renewal)
    {
        $current_certificate_number = CertificateNumber::where('renewal_period_id', $renewal->renewal_period_id)
            ->first();
        if ($current_certificate_number == null) {
            $current_certificate_number = CertificateNumber::create([
                'renewal_period_id' => $renewal->renewal_period_id,
                'certificate_number' => 0,
            ]);
        }
        $certificate_number = $current_certificate_number->certificate_number + 1;
        $current_certificate_number->update([
            'certificate_number' => $certificate_number
        ]);
        $practitioner_id = $renewal->practitioner->id;
        $renewal->update([
            'certificate' => 1,
            'certificate_number' => $certificate_number
        ]);

        return redirect('/admin/practitioners/' . $renewal->practitioner->id)
            ->with('message', 'Renewal for ' . $renewal->renewal_period_id . ' has been verified and awaits registrar to approve. ');
    }

    public function sign_off(Renewal $renewal)
    {
        $practitioner_id = $renewal->practitioner->id;
        $practitioner = $renewal->practitioner->id;
        $renewal->update([
            'certificate' => 2,
        ]);

        /* if ($practitioner->contact) {
             $email = $practitioner->contact->email;
             Mail::to($email)->send(new SignOff($renewal));
         }*/

        return redirect('/admin/practitioners/' . $renewal->practitioner->id)
            ->with('message', 'Renewal for ' . $renewal->renewal_period_id . ' has been ceritified and practitioner will have right to print certificate. ');
    }


    //check cd points
    public function cdpoints(Practitioner $practitioner)
    {
        $cdpoints = $practitioner->profession->cdpoint;
        return view('admin.practitioner_payments.cdpoints', compact('practitioner', 'cdpoints'));
    }

    //check placement
    public function createPlacement(Practitioner $practitioner)
    {
        $cdpoints = $practitioner->profession->cdpoint;
        return view('admin.practitioner_internship.placement', compact('practitioner', 'cdpoints'));
    }

    //store cd points
    public function storeCdpoints(Practitioner $practitioner)
    {
        $path = '';
        $renewal_period_id = request('renewal_period_id');

        $checkExist = PractitionerCpdpoint::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
        if ($checkExist) {
            return back()->with('message', 'CPD points for this period have already been submitted');
        } else {

            if (request()->hasfile('file')) {

                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('cpdpoints', $file_name);

            }

            $yearly_cdpoints['renewal_period_id'] = request('renewal_period_id');
            $yearly_cdpoints['practitioner_id'] = $practitioner->id;
            $yearly_cdpoints['points'] = request('points');
            $yearly_cdpoints['path'] = $path;
            //get set cd points
            $cdpoints = $practitioner->profession->cdpoint;
            //get submitted cd points
            $points = request('points');
            if ($points == $cdpoints->points) {
                $practitioner->addCdPoints($yearly_cdpoints);
                //now check if cpd points renewal_period_id matches with a renewal_period_id
                //in the renewals table

                $checkRenewalExist = Renewal::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
                if ($checkRenewalExist) {
                    $checkRenewalExist->update([
                        'cdpoints' => 1,
                    ]);
                }
                return back()->with('message', 'Cd Points added successfully');
            } else {
                return back()->with('message', 'Cd Points do not match the required CPD Points');

            }
        }


    }

    //store placement
    public function storePlacement(Practitioner $practitioner)
    {
        $path = '';
        $renewal_period_id = request('renewal_period_id');

        $checkExist = PractitionerPlacement::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
        if ($checkExist) {
            return back()->with('message', 'Placement for this renewal period has already been submitted');
        } else {

            if (request()->hasfile('file')) {

                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('placements', $file_name);

            }

            $yearly_placement['renewal_period_id'] = request('renewal_period_id');
            $yearly_placement['practitioner_id'] = $practitioner->id;
            $yearly_placement['path'] = $path;

            //get set placement status for that profession
            $placement = $practitioner->profession->cdpoint;
            //get submitted cd points
            if ($placement->placement == 1) {
                $practitioner->addPlacement($yearly_placement);
                //now check if placement renewal_period_id matches with a renewal_period_id
                //in the renewals table
                $checkRenewalExist = Renewal::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
                if ($checkRenewalExist) {
                    $checkRenewalExist->update([
                        'placement' => 1,
                    ]);
                }
                return back()->with('message', 'Placement letter uploaded successfully ');
            } else {
                return back()->with('message', 'Placement letter could not be uploaded');

            }
        }


    }

    //view placement letter
    public function viewPlacement($id)
    {
        $placement = PractitionerPlacement::find($id);
        return view('admin.practitioner_placement.view', compact('placement'));
    }

    //invoice balance
    public function invoiceBalances(Practitioner $practitioner)
    {
        $vat = Vat::where('id', 1)->first();
        $renewal_fee = RenewalFee::whereRenewal_category_idAndProfession_id($practitioner->renewal_category_id, $practitioner->profession_id)->first();

        $fee = ($renewal_fee->fee * $vat->vat) + $renewal_fee->fee;


        return view('admin.practitioner_payments.renewal_invoice_balances', compact('practitioner', 'fee'));
    }

    //invoice Renewals
    public function invoiceRenewal(Practitioner $practitioner)
    {
        $vat = Vat::where('id', 1)->first();

        //$renewal_fee = RenewalFee::whereRenewal_category_idAndProfession_id($practitioner->renewal_category_id, $practitioner->profession_id)->first();
        $renewal_fee = 200;

        $fee = ($renewal_fee * $vat->vat) + $renewal_fee;
        return view('admin.practitioner_payments.renewal_invoice',
            compact('practitioner', 'renewal_fee', 'vat', 'fee'));

    }

}
