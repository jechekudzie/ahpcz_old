<?php

namespace App\Http\Livewire;


use App\CpdCriteria;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Payment;
use App\PaymentChannel;
use App\Profession;
use App\Rate;
use App\Renewal;
use App\RenewalCriteria;
use App\Vat;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Carbon\CarbonInterval;
use Livewire\WithFileUploads;

class CreateRenewal extends Component
{
    use WithFileUploads;

    public $professions;
    public $practitioner;
    public $employment_status_id;
    public $employment_location_id;
    public $certificate_request;
    public $dob;
    public $age;
    public $profession;
    public $created_at;

    public $renewal_criteria;
    public $cpd_criteria;
    public $points;
    public $profession_tire_fee;
    public $renewal_fee;
    public $renewal_category_id;
    public $renewal_criteria_percentage;
    public $balance;
    public $message = 'Please choose from the following option to get your renewal status and fees';

    //steps logic
    public $step;
    //file upload
    public $path;
    public $file;

    //calculate renewals
    public $period;//this is period in which you paying for
    public $amount_invoiced;//this is current renewal fee + balance
    public $amount_paid;//this is the amount to be submitted as paid
    public $receipt_number;//a new unique receipt number from pastel
    public $payment_date;//payment channel used
    public $payment_channel_id;//payment channel used
    public $pop;//proof of payment
    public $renewal_balance = 0;
    public $renewals;
    public $payments;
    public $cpd_points;
    public $rate;
    public $currency = 1;
    public $add_renewal;
    public $add_renewal_payment;
    public $restoration_penalty_fee;

    //save payment
    public function make_payment()
    {
        $this->validate([
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'receipt_number' => ['required', 'digits_between:4,8', 'numeric', 'unique:payments'],
            'payment_date' => 'required',
            'payment_channel_id' => 'required',
            'pop' => 'nullable',

            'points' => 'required',
            'file' => 'nullable',

            'dob' => 'required',
            'employment_status_id' => 'required',
            'employment_location_id' => 'required',
            'certificate_request' => 'required',

        ], [
            'dob.required' => 'Date of birth is required',
            'employment_status_id.required' => 'Employment status is required',
            'employment_location_id.required' => 'Country of residence is required',
            'certificate_request.required' => 'Please specify if you need a certificate or note.',
            'points.required' => 'Points are required',
            'amount_paid.required' => 'Amount required is required',
            'receipt_number.required' => 'Must contain only numbers and a length between 4 and 8',
            'payment_date.required' => 'Payment date is required',
            'payment_channel_id.required' => 'Payment channel is required',
        ]);

        //first step check to see if the amount invoice was full paid or there is a balance
        $this->renewal_balance = $this->amount_invoiced - $this->amount_paid;
        $this->renewals['renewal_period_id'] = $this->period;
        $this->renewals['practitioner_id'] = $this->practitioner->id;
        $this->renewals['payment_method_id'] = 1;
        $this->renewals['renewal_category_id'] = $this->renewal_category_id;
        $this->renewals['currency'] = $this->currency;
        $this->renewals['balance'] = $this->renewal_balance;
        $this->renewals['payment_type_id'] = 1; //a renewal payment type
        $this->renewals['certificate_request'] = $this->certificate_request;
        $this->renewals['placement'] = 1;
        if ($this->renewal_balance > 0) {
            $this->renewals['renewal_status_id'] = 3;
        } else {
            $this->renewals['renewal_status_id'] = 1;
        }

        if ($this->points >= $this->cpd_criteria) {
            $this->renewals['cdpoints'] = 1;
            $this->cpd_points['practitioner_id'] = $this->practitioner->id;
            $this->cpd_points['renewal_period_id'] = $this->period;
            $this->cpd_points['points'] = $this->points;
            $this->save_cpd_file();
            $this->cpd_points['path'] = $this->path;
            $this->practitioner->addCdPoints($this->cpd_points);
        } else {
            $this->renewals['cdpoints'] = 0;
        }

        //now check if the practitioner already for this current year
        if (Renewal::where('practitioner_id', $this->practitioner->id)->where('renewal_period_id', $this->period)->first()) {

            return back()->with('message',
                'A renewal subscription for the selected period is already active,
            not that if this a regular payment click the payment link to proceed');

        } else {

            $this->add_renewal = $this->practitioner->addRenewal($this->renewals);
            $this->payments['renewal_period_id'] = $this->period;
            $this->payments['renewal_id'] = $this->add_renewal->id;
            $this->payments['month'] = date('m');
            $this->payments['day'] = date('d');
            $this->payments['practitioner_id'] = $this->practitioner->id;
            $this->payments['balance'] = $this->renewal_balance;
            $this->payments['amount_invoiced'] = $this->amount_invoiced;
            $this->payments['amount_paid'] = $this->amount_paid;
            $this->payments['payment_channel_id'] = $this->payment_channel_id;
            $this->payments['rate'] = $this->rate;
            $this->payments['currency'] = $this->currency;
            $this->payments['receipt_number'] = $this->receipt_number;
            $this->payments['payment_item_category_id'] = 1;
            $this->payments['payment_date'] = $this->payment_date;
            $this->payments['payment_item_id'] = 33;
            $this->add_renewal_payment = $this->add_renewal->addPayments($this->payments);

            //update previous balances to 0
            if ($this->renewal_balance > 0) {
                if (count($this->practitioner->payments)) {
                    foreach ($this->practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $this->add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            }
            else {

                if (count($this->practitioner->payments)) {
                    foreach ($this->practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $this->add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }

            }
            session()->flash('message', 'Renewal payment was successful!.');
            return redirect('/admin/practitioners/' . $this->practitioner->id);

        }
    }

    public function increase_step()
    {
        if ($this->step == 0) {
            $this->validate([
                'dob' => 'required',
                'employment_status_id' => 'required',
                'employment_location_id' => 'required',
                'certificate_request' => 'required',

            ],
                [
                    'dob.required' => 'Date of birth is required',
                    'employment_status_id.required' => 'Employment status is required',
                    'employment_location_id.required' => 'Country of residence is required',
                    'certificate_request.required' => 'Please specify if you need a certificate or note.',
                ]);
        }

        if ($this->step == 1) {
            $this->validate([
                'points' => 'required',
                'file' => 'nullable',
            ],
                [
                    'points.required' => 'Points are required',
                ]);

        }

        if ($this->step == 2) {
            $this->validate([
                'amount_paid' => 'required',
                'receipt_number' => ['required', 'digits_between:4,8', 'numeric', 'unique:payments'],
                'payment_date' => 'required',
                'payment_channel_id' => 'required',

            ],
                [
                    'amount_paid.required' => 'Amount required is required',
                    'receipt_number.required' => 'Must contain only numbers and a length between 4 and 8',
                    'payment_date.required' => 'Payment date is required',
                    'payment_channel_id.required' => 'Payment channel is required',
                ]);

        }
        $this->step++;
    //dd($this->cpd_criteria);

    }

    public function decrease_step()
    {
        if ($this->step > 0) {
            $this->step--;
        }

    }

    public function save_cpd_file()
    {
        if($this->file !=null){
            $this->path = $this->file->store('public/cpd_points');
        }
    }

    public function get_renewal_category()
    {
        if (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 1 &&
            $this->employment_location_id == 1 && $this->certificate_request == 1) {
            $this->renewal_category_id = 1;//working in zim active local
        } elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 1
            && $this->employment_location_id == 2 && $this->certificate_request == 1) {
            $this->renewal_category_id = 2;//working outside zim active foreign
        } elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 1
            && $this->employment_location_id == 2 && $this->certificate_request == 2) {
            $this->renewal_category_id = 4;//maintenance without certificate (for foreign)
        } elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 2 && $this->certificate_request == 2) {
            $this->renewal_category_id = 4;//maintenance without certificate (for foreign)
        } elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 1 && $this->certificate_request == 2) {
            $this->renewal_category_id = 4;//maintenance without certificate (for local)
        } elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 1 && $this->certificate_request == 1) {
            $this->renewal_category_id = 3;//maintenance with certificate (for local)
        } elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 2 && $this->certificate_request == 1) {
            $this->renewal_category_id = 3;//maintenance with certificate (for foreign)
        } elseif (($this->age >= 60 && $this->age <= 64)) {
            $this->renewal_category_id = 5;//between 60 and 64
        } elseif (($this->age >= 65 && $this->age <= 74)) {
            $this->renewal_category_id = 6;//between 65 and 74
        } elseif (($this->age >= 75)) {
            $this->renewal_category_id = 7;// 75 and above
        } elseif ($this->employment_status_id == 1 && $this->employment_location_id == 1 && $this->certificate_request == 2) {
            $this->message = "Please note that if you are practising locally,
             you are required to have a certificate, regardless of age group or other conditions";
        } else {
            $this->renewal_category_id = 0;
            if ($this->renewal_category_id == 0) {
                $this->message = 'To qualify for renewal, please make sure you complete the selection below.';
            }
        }
    }
    public function get_cpd_criteria()
    {
        $this->cpd_criteria = CpdCriteria::where('profession_id', $this->profession->id)
            ->where('employment_status_id', $this->employment_status_id)->first();
        if ($this->cpd_criteria == null){
            $this->cpd_criteria = 0;
        }else{
            $this->cpd_criteria = $this->cpd_criteria->points;
        }
    }

    public function get_renewal_criteria(){
        $this->renewal_criteria = RenewalCriteria::where('renewal_category_id', $this->renewal_category_id)
            ->where('employment_status_id', $this->employment_status_id)
            ->where('employment_location_id', $this->employment_location_id)
            ->where('certificate_request', $this->certificate_request)->first();
    }

    public function get_percentage_and_balance()
    {
        if ($this->renewal_criteria) {
            $this->renewal_criteria_percentage = $this->renewal_criteria->percentage / 100;
        }

    }

   /* public function calculate_renewal_fee()
    {
        $this->renewal_fee = $this->profession_tire_fee * $this->renewal_criteria_percentage;
        if($this->currency == 0){
            $this->amount_invoiced = $this->renewal_fee + $this->balance;
        }
        if($this->currency == 1){
            $this->amount_invoiced = $this->renewal_fee + $this->balance;
            $this->amount_invoiced = round($this->amount_invoiced / $this->rate,3);
        }

    }*/
    public function calculate_renewal_fee()
    {
        $this->renewal_fee = $this->profession_tire_fee * $this->renewal_criteria_percentage;
        $this->restoration_penalty_fee = Session::get('restoration')['restoration_penalty_fee'];
        $this->balance = Session::get('restoration')['balance'];
        if ($this->currency == 1) {
            $this->amount_invoiced = $this->restoration_penalty_fee + $this->balance + ($this->renewal_fee * 1.145);
            $this->amount_invoiced = ceil($this->amount_invoiced);
        }
        if ($this->currency == 0) {
            $this->amount_invoiced = ($this->restoration_penalty_fee + $this->balance) * $this->rate + ($this->renewal_fee * 1.145 * $this->rate);
            $this->amount_invoiced = round($this->amount_invoiced, 3);
        }

    }

    public function mount()
    {
        $this->dob = $this->practitioner->dob;
        $this->employment_status_id = $this->practitioner->employment_status_id;
        $this->employment_location_id = $this->practitioner->employment_location_id;
        $this->profession = $this->practitioner->profession;
        $this->age = date('Y') - date('Y', strtotime($this->dob));
        $this->profession_tire_fee = $this->practitioner->profession->profession_tire->tire->fee;
        $this->rate = Rate::find(1)->rate;
        $this->get_renewal_category();
        $this->get_renewal_criteria();
        $this->get_cpd_criteria();
        $this->get_percentage_and_balance();
        $this->calculate_renewal_fee();
        //initializing step
        $this->step = 0;

    }

    public function updated()
    {
        $this->dob = $this->dob;
        $this->age = date('Y') - date('Y', strtotime($this->dob));

        $this->get_renewal_category();
        $this->get_renewal_criteria();
        $this->get_cpd_criteria();
        $this->get_percentage_and_balance();
        $this->calculate_renewal_fee();
    }

    public function render()
    {
        return view('livewire.create-renewal', [
            'employment_statuses' => EmploymentStatus::all(),
            'employment_locations' => EmploymentLocation::all(),
            'payment_channels' => PaymentChannel::all(),
        ]);
    }
}
