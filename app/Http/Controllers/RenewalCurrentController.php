<?php

namespace App\Http\Controllers;

use App\CpdCriteria;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Practitioner;
use App\Rate;
use App\RenewalCriteria;
use Illuminate\Http\Request;

class RenewalCurrentController extends Controller
{
    //
    public function initiate_step_1(Practitioner $practitioner)
    {
        //get renewal criteria data
        $employment_statuses = EmploymentStatus::all();
        $employment_locations = EmploymentLocation::all();
        $dob = $practitioner->dob;
        return view('renewals.step_1',compact('employment_statuses',
            'employment_locations','practitioner',
        'dob'));
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
        $status = 0;
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

        if (count($practitioner->renewals)) {
            $renewals = $practitioner->renewals;
            $size = sizeof($renewals);
            $last_renewal_period = $renewals[$size - 1]->renewal_period_id;

            $result = $this->check_restoration_penalties($practitioner, $last_renewal_period, $renewal_criteria);
            //dd($result);
            /*return response()->json([
                'result' => $result,
                'data' => $data,
                'status' => 1,
                'rate' => $rate,
                'renewal_criteria' => $renewal_criteria,
            ]);*/
            return view('renewals.step_2',
                compact('data','status','practitioner','rate','renewal_criteria'));
        }
        if (request('last_renewal_period') != null) {
            $last_renewal_period = request('last_renewal_period');
            $result = $this->check_restoration_penalties($practitioner, $last_renewal_period, $renewal_criteria);
            //dd($result);
            /*return response()->json([
                'result' => $result,
                'data' => $data,
                'status' => 1,
                'rate' => $rate,
                'renewal_criteria' => $renewal_criteria,
            ]);*/
            return view('renewals.step_2',
                compact('data','status','practitioner','rate','renewal_criteria'));
        }

       /* return response()->json([
            'data' => $data,
            'status' => 0,
        ]);*/

        return view('renewals.step_2',
            compact('data','status','practitioner'));

    }

    public function calculate_age($dob)
    {

        return $age = date('Y') - date('Y', strtotime($dob));
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
