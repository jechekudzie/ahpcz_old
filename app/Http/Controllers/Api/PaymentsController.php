<?php

namespace App\Http\Controllers\Api;

use App\CpdCriteria;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Http\Controllers\Controller;
use App\PaymentItem;
use App\PaymentItemCategory;
use App\Practitioner;
use App\Rate;
use App\Renewal;
use App\RenewalCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    //
    public function renewals(Practitioner $practitioner)
    {
        if ($practitioner->renewals) {
            foreach ($practitioner->renewals as $renewal) {
                if ($renewal->renewalStatus) {
                    $renewal->renewalStatus;
                }
                if ($renewal->payments) {
                    foreach ($renewal->payments as $payment) {
                        $payment->paymentItem;
                        $payment->paymentItemCategory;
                        $payment->paymentChannel;
                    }
                }
            }
        }
        if ($practitioner->currentRenewal) {
            $practitioner->currentRenewal;
        }

        return response()->json([
            'renewals' => $practitioner->renewals,
            'current_renewal' => $practitioner->currentRenewal,
        ]);
    }

    public function renewal_payments(Renewal $renewal)
    {
        if ($renewal) {
            if ($renewal->payments) {
                foreach ($renewal->payments as $payment) {
                    $payment->paymentItem;
                    $payment->paymentItemCategory;
                    $payment->paymentChannel;
                }
                return response()->json([
                    'renewal' => $renewal,
                ]);
            }
        }
    }

    public function initiate_step_1(Practitioner $practitioner)
    {
        //get renewal criteria data
        $employment_statuses = EmploymentStatus::all();
        $employment_locations = EmploymentLocation::all();
        return response()->json([
            'employment_statuses' => $employment_statuses,
            'employment_locations' => $employment_locations,
            'dob' => $practitioner->dob,
        ]);
    }

    public function step_1(Practitioner $practitioner)
    {
        //calculate fee with or without penalties/ restoration
        $data = request()->validate([
            'dob' => 'required',
            'employment_status_id' => 'required',
            'employment_location_id' => 'required',
            'certificate_request' => 'required',
            'last_renewal_period' => 'nullable',
        ]);

        $total = 0;
        $balance = 0;
        $rate = Rate::find(1)->rate;

        $age = date('Y') - date('Y', strtotime($data['dob']));
        $employment_status_id = $data['employment_status_id'];
        $employment_location_id = $data['employment_location_id'];
        $certificate_request = $data['certificate_request'];
        $dob = $data['dob'];

        //update the above for practitioner except for certificate request value
        $practitioner->update([
            'employment_status_id' => $employment_status_id,
            'employment_location_id' => $employment_location_id,
            'dob' => $dob,
        ]);

        $renewal_category_id = $this->get_renewal_category($age, $employment_status_id, $employment_location_id, $certificate_request);
        $renewal_criteria = $this->get_renewal_criteria($renewal_category_id, $employment_status_id, $employment_location_id, $certificate_request);
        //check if selected criteria matches any of the existing
        if ($renewal_criteria == null) {
            return response()->json([
                'status' => 2,
            ]);
        }
        if (count($practitioner->renewals)) {
            $renewals = $practitioner->renewals;
            $size = sizeof($renewals);
            $last_renewal_period = $renewals[$size - 1]->renewal_period_id;

            $result = $this->check_restoration_penalties($practitioner, $last_renewal_period, $renewal_criteria);
            return response()->json([
                'result' => $result,
                'data' => $data,
                'status' => 1,
                'rate' => $rate,
                'renewal_criteria' => $renewal_criteria,
            ]);
        }
        if (request('last_renewal_period') != null) {
            $last_renewal_period = request('last_renewal_period');
            $result = $this->check_restoration_penalties($practitioner, $last_renewal_period, $renewal_criteria);
            return response()->json([
                'result' => $result,
                'data' => $data,
                'status' => 1,
                'rate' => $rate,
                'renewal_criteria' => $renewal_criteria,
            ]);
        }

        return response()->json([
            'data' => $data,
            'status' => 0,
        ]);

    }

    //make payments
    public function step_3()
    {
        $data = request()->validate([
            'period' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'payment_channel_id' => 'required',
            'currency' => 'required',
            'pop' => 'nullable',
            'certificate_request' => 'required',
            'practitioner_id' => 'required',
            'renewal_category_id' => 'required',
            'renewal_criteria_id' => 'required',
            'rate' => 'required',
        ]);
        $practitioner = Practitioner::find($data['practitioner_id']);

        $path = '';
        $pop = '';
        $status = 0;
        $renewal_balance = 0;
        //step 1 - check if renewal exist
        if (Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            return response()->json([
                'response_status' => 0,
                'message' =>
                    'A renewal subscription for the selected period is already active,
                note that if this a regular payment click Make Payment and choose the respective item']);
        } else {
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

            //check balance status
            if ($renewal_balance > 0) {
                $renewals['renewal_status_id'] = 3;
            } else {
                $renewals['renewal_status_id'] = 1;
            }
            //save renewal_balance in USD
            if ($data['currency'] == 1) {
                $renewal_balance = $renewal_balance;
            }
            if ($data['currency'] == 0) {
                $renewal_balance = $renewal_balance / $data['rate'];
            }

            //get Pop
            if (request()->hasfile('pop')) {
                //get the file field data and name field from form submission
                $file = request()->file('pop');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $pop = $file->move('pops', $file_name);
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
            $payments['payment_date'] = now();
            $payments['payment_item_id'] = 33;
            $payments['pop'] = $path;
            $payments['proof'] = $pop;
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
                'response_status' => 1,
                'message' => 'Renewal Payment Was successful.',
            ]);
        }
    }

    //get cpds
    public function step_4()
    {
        $path = '';
        //validate incoming data
        $data = request()->validate([
            'practitioner_id' => 'required',
            'cpd_points' => 'required',
            'renewal_period_id' => 'required',
            'required_points' => 'required',
        ]);

        //get renewal and practitioner details for update
        $practitioner_id = (int)request('practitioner_id');
        $practitioner = Practitioner::where('id', $practitioner_id)->first();
        $renewal = Renewal::where('practitioner_id', $practitioner_id)
            ->where('renewal_period_id', $data['renewal_period_id'])->first();

        //add cpd points
        if ($data['cpd_points'] >= $data['required_points']) {
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
            $renewal->update([
                'cdpoints' => 1
            ]);
            $cpd_points['practitioner_id'] = $practitioner->id;
            $cpd_points['renewal_period_id'] = $data['renewal_period_id'];
            $cpd_points['points'] = $data['cpd_points'];
            $cpd_points['path'] = $path;
            $add_cpd_points = $practitioner->addCdPoints($cpd_points);

            $payment = $renewal->payments->where('renewal_period_id', $data['renewal_period_id'])->first();
            $payment->update([
                'pop' => $path
            ]);

            return response()->json([
                'message' => 'Your renewal payment was successful. Your will be notified once your certificate is ready.',
            ]);
        } else {

            return response()->json([
                'message' => 'Your Cpd Points submitted successfully.
                You need to update your required cpd points in order to get a certificate.',
            ]);
        }
    }

    public function make_balance_payment()
    {
        $data = request()->validate([
            'practitioner_id' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'currency' => 'required',
            'payment_channel_id' => 'required',
            'period' => 'required',
            'rate' => 'required',
            'pop' => 'nullable',
        ]);

        $practitioner = Practitioner::find($data['practitioner_id']);

        $pop = '';
        $status = 0;
        $balance = $data['amount_invoiced'] - $data['amount_paid'];
        //save renewal_balance in USD
        if ($data['currency'] == 1) {
            $balance = $balance;
        }
        if ($data['currency'] == 0) {
            $balance = $balance / $data['rate'];
        }
        if ($renewal = Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            $status = 1;
            //get Pop
            if (request()->hasfile('pop')) {
                //get the file field data and name field from form submission
                $file = request()->file('pop');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $pop = $file->move('pops', $file_name);
            }
            $payments['renewal_period_id'] = $data['period'];
            $payments['renewal_id'] = $renewal->id;
            $payments['month'] = date('m');
            $payments['day'] = date('d');
            $payments['practitioner_id'] = $practitioner->id;
            $payments['balance'] = $balance;
            $payments['amount_invoiced'] = $data['amount_invoiced'];
            $payments['amount_paid'] = $data['amount_paid'];
            $payments['payment_channel_id'] = $data['payment_channel_id'];
            $payments['rate'] = $data['rate'];
            $payments['currency'] = $data['currency'];
            $payments['payment_item_category_id'] = 1;
            $payments['payment_date'] = now();
            $payments['payment_item_id'] = 42;
            $payments['proof'] = $pop;
            $add_renewal_payment = $renewal->addPayments($payments);

            //update previous balances to 0
            if ($balance > 0) {
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
                'response_status' => 1,
                'message' => 'Renewal Payment Was successful.',
            ]);
        }

    }

    public function get_renewal_category($age, $employment_status_id, $employment_location_id, $certificate_request)
    {
        $message = '';
        $renewal_category_id = 0;
        if (($age > 0 && $age < 60) && $employment_status_id == 1 &&
            $employment_location_id == 1 && $certificate_request == 1) {
            $renewal_category_id = 1;//working in zim active local
        } elseif (($age > 0 && $age < 60) && $employment_status_id == 1
            && $employment_location_id == 2 && $certificate_request == 1) {
            $renewal_category_id = 2;//working outside zim active foreign
        } elseif (($age > 0 && $age < 60) && $employment_status_id == 1
            && $employment_location_id == 2 && $certificate_request == 2) {
            $renewal_category_id = 4;//maintenance without certificate (for foreign)
        } elseif (($age > 0 && $age < 60) && $employment_status_id == 2
            && $employment_location_id == 2 && $certificate_request == 2) {
            $renewal_category_id = 4;//maintenance without certificate (for foreign)
        } elseif (($age > 0 && $age < 60) && $employment_status_id == 2
            && $employment_location_id == 1 && $certificate_request == 2) {
            $renewal_category_id = 4;//maintenance without certificate (for local)
        } elseif (($age > 0 && $age < 60) && $employment_status_id == 2
            && $employment_location_id == 1 && $certificate_request == 1) {
            $renewal_category_id = 3;//maintenance with certificate (for local)
        } elseif (($age > 0 && $age < 60) && $employment_status_id == 2
            && $employment_location_id == 2 && $certificate_request == 1) {
            $renewal_category_id = 3;//maintenance with certificate (for foreign)
        } elseif (($age >= 60 && $age <= 64)) {
            $renewal_category_id = 5;//between 60 and 64
        } elseif (($age >= 65 && $age <= 74)) {
            $renewal_category_id = 6;//between 65 and 74
        } elseif (($age >= 75)) {
            $renewal_category_id = 7;// 75 and above
        } elseif ($employment_status_id == 1 && $employment_location_id == 1 && $certificate_request == 2) {
            $message = "Please note that if you are practising locally,
             you are required to have a certificate, regardless of age group or other conditions";
        } else {
            $message = 'To qualify for renewal, please make sure you complete the selection below.';

        }

        return $renewal_category_id;
    }

    public function get_renewal_criteria($renewal_category_id, $employment_status_id, $employment_location_id, $certificate_request)
    {
        $renewal_criteria = null;
        $renewal_criteria = RenewalCriteria::
        where('renewal_category_id', $renewal_category_id)
            ->where('employment_status_id', $employment_status_id)
            ->where('employment_location_id', $employment_location_id)
            ->where('certificate_request', $certificate_request)->first();

        return $renewal_criteria;
    }

    public function check_restoration_penalties(Practitioner $practitioner, $last_renewal_period, $renewal_criteria)
    {
        $tire = $practitioner->profession->profession_tire->tire;
        $profession = $practitioner->profession;
        $current_period = date('Y');
        $current_month = date('m');

        $cpd_criterias = CpdCriteria::all();
        $renewal_fee = 0;
        $amount_invoiced = 0;
        $cpd_points = 0;
        $renewal_criteria_percentage = ($renewal_criteria->percentage / 100);
        $restoration_penalty_name = '';
        $restoration_penalty_charge = 0;
        $balance = 0;
        //calculate balances
        if ($practitioner->payments) {
            foreach ($practitioner->payments as $payment) {
                $balance = $balance + $payment->balance;
            }
        }


        //step 1 - get cpd criterias
        foreach ($cpd_criterias as $cpd_criteria) {
            if ($cpd_criteria->profession_id == $profession->id) {
                $cpd_points = $cpd_criteria;
            }
        }
        //step 2 - check restoration or penalty first calculate result
        $result = $current_period - $last_renewal_period;
        if ($result == 1 && $current_month > 06) {
            $restoration_penalty_name = 'Restoration current year';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 1.397 + $balance);
                $restoration_penalty_charge = 1.397;
            }

            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 1.657 + $balance);
                $restoration_penalty_charge = 1.657;
            }

            if ($tire->id == 3) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 1.2 + $balance);
                $restoration_penalty_charge = 1.2;
            }

            $cpd_points = $cpd_points->where('employment_status_id', $practitioner->employment_status_id)->first()->points;
            return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);

        } elseif ($result == 2) {
            $restoration_penalty_name = 'Restoration level 1';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 1.793 + $balance);
                $restoration_penalty_charge = 1.793;
            }

            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 2.314 + $balance);
                $restoration_penalty_charge = 2.314;
            }
            $cpd_points = $cpd_points->standard * 1.5;

            return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);

        } elseif ($result >= 3 && $result <= 5) {
            $restoration_penalty_name = 'Restoration level 2';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 2.172 + $balance);
                $restoration_penalty_charge = 2.172;
            }

            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 2.971 + $balance);
                $restoration_penalty_charge = 2.971;
            }
            $cpd_points = $cpd_points->standard * 2;
            return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);

        } elseif ($result > 5) {
            $restoration_penalty_name = 'Restoration level 3';
            if ($tire->id == 1) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 2.569 + $balance);
                $restoration_penalty_charge = 2.569;
            }
            if ($tire->id == 2) {
                $renewal_fee = ceil($tire->fee * 1.145);
                $amount_invoiced = ceil($renewal_fee * 3.6 + $balance);
                $restoration_penalty_charge = 3.6;
            }
            $cpd_points = $cpd_points->standard * 3;
            return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);

        } elseif ($result == 1) {
            if ($current_month == 04) {
                $restoration_penalty_name = 'Penalty level 1 = 5%';
                $renewal_fee = ceil($tire->fee * 1.145);

                //now multiply by renewal criteria %
                $renewal_fee = ceil($renewal_fee * $renewal_criteria_percentage);

                $amount_invoiced = ceil($renewal_fee * 1.05 + $balance);
                $restoration_penalty_charge = 1.05;
                $cpd_points = $cpd_points->where('employment_status_id', $practitioner->employment_status_id)->first()->points;
                return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);
            }
            if ($current_month == 05) {
                $restoration_penalty_name = 'Penalty level 2 = 10%';
                $renewal_fee = ceil($tire->fee * 1.145);

                //now multiply by renewal criteria %
                $renewal_fee = ceil($renewal_fee * $renewal_criteria_percentage);

                $amount_invoiced = ceil($renewal_fee * 1.10 + $balance);
                $restoration_penalty_charge = 1.10;
                $cpd_points = $cpd_points->where('employment_status_id', $practitioner->employment_status_id)->first()->points;
                return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);
            }
            if ($current_month == 06) {

                $restoration_penalty_name = 'Penalty level 3 = 15%';
                $renewal_fee = ceil($tire->fee * 1.145);

                //now multiply by renewal criteria %
                $renewal_fee = ceil($renewal_fee * $renewal_criteria_percentage);

                $amount_invoiced = ceil($renewal_fee * 1.15 + $balance);
                $restoration_penalty_charge = 1.15;
                $cpd_points = $cpd_points->where('employment_status_id', $practitioner->employment_status_id)->first()->points;
                return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);

            }
            if ($current_month > 06) {
                if ($tire->id == 1) {
                    $restoration_penalty_name = 'Current Restoration = 39.7%';
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $amount_invoiced = ceil($renewal_fee * 1.397 + $balance);
                    $restoration_penalty_charge = 1.397;
                }

                if ($tire->id == 2) {
                    $restoration_penalty_name = 'Current Restoration = 65.7%';
                    $renewal_fee = ceil($tire->fee * 1.145);
                    $amount_invoiced = ceil($renewal_fee * 1.657 + $balance);
                    $restoration_penalty_charge = 1.657;
                }
                $cpd_points = $cpd_points->where('employment_status_id', $practitioner->employment_status_id)->first()->points;
                return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);

            }


        } else {

            $restoration_penalty_name = 'No restoration no penalty';
            $renewal_fee = ceil($tire->fee * 1.145);

            //now multiply by renewal criteria %
            $renewal_fee = ceil($renewal_fee * $renewal_criteria_percentage);

            $amount_invoiced = ceil($renewal_fee + $balance);
            $restoration_penalty_charge = 0;
            $cpd_points = $cpd_points->where('employment_status_id', $practitioner->employment_status_id)->first()->points;
            return $this->store_restoration($restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge);
        }

    }

    public function store_restoration(
        $restoration_penalty_name, $amount_invoiced, $cpd_points, $restoration_penalty_charge)
    {
        $restoration = [
            'restoration_penalty_name' => $restoration_penalty_name,
            'amount_invoiced' => $amount_invoiced,
            'cpd_points' => $cpd_points,
            'restoration_penalty_charge' => $restoration_penalty_charge,
        ];
        return $restoration;

    }


}
