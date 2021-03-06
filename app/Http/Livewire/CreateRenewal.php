<?php

namespace App\Http\Livewire;


use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Profession;
use App\RenewalCriteria;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Livewire\Component;
use Carbon\CarbonInterval;

class CreateRenewal extends Component
{

    public $professions;
    public $practitioner;
    public $employment_status_id = 0;
    public $employment_location_id = 0;
    public $certificate_request = 0;
    public $dob;
    public $age;
    public $profession;
    public $created_at;
    public $renewal_criteria;
    public $renewal_category_id;
    public $message = 'Please choose from the following option to get your renewal status and fees';

    public function get_renewal_category()
    {
        if (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 1 &&
            $this->employment_location_id == 1 && $this->certificate_request == 1) {
            $this->renewal_category_id = 1;//working in zim active local
        }
        elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 1
            && $this->employment_location_id == 2 && $this->certificate_request == 1) {
            $this->renewal_category_id = 2;//working outside zim active foreign
        }
        elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 1
            && $this->employment_location_id == 2 && $this->certificate_request == 2) {
            $this->renewal_category_id = 4;//maintenance without certificate (for foreign)
        }
        elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 2 && $this->certificate_request == 2) {
            $this->renewal_category_id = 4;//maintenance without certificate (for foreign)
        }
        elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 1 && $this->certificate_request == 2) {
            $this->renewal_category_id = 4;//maintenance without certificate (for local)
        }
        elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 1 && $this->certificate_request == 1) {
            $this->renewal_category_id = 3;//maintenance with certificate (for local)
        }
        elseif (($this->age > 0 && $this->age < 60) && $this->employment_status_id == 2
            && $this->employment_location_id == 2 && $this->certificate_request == 1) {
            $this->renewal_category_id = 3;//maintenance with certificate (for foreign)
        }
        elseif (($this->age >= 60 && $this->age <= 64)) {
            $this->renewal_category_id = 5;//between 60 and 64
        }
        elseif (($this->age >= 65 && $this->age <= 74)) {
            $this->renewal_category_id = 6;//between 65 and 74
        }
        elseif (($this->age >= 75 )) {
            $this->renewal_category_id = 7;// 75 and above
        }elseif ($this->employment_status_id == 1 &&  $this->employment_location_id == 1 && $this->certificate_request == 2) {
                $this->message = "Please note that if you are practising locally,
             you are required to have a certificate, regardless of age group or other conditions";
        }
        else {
            $this->renewal_category_id = 0;
            if($this->renewal_category_id == 0){
                $this->message = 'To qualify for renewal, please make sure you complete the selection below.';
            }
        }
    }
    public function mount()
    {
        $this->dob = $this->practitioner->dob;
        $this->age = date('Y') - date('Y', strtotime($this->dob));
        $this->get_renewal_category();
        $this->renewal_criteria = RenewalCriteria::where('renewal_category_id', $this->renewal_category_id)
            ->where('employment_status_id', $this->employment_status_id)
            ->where('employment_location_id', $this->employment_location_id)
            ->where('certificate_request', $this->certificate_request)->first();


    }

    public function updated()
    {
        $this->age = date('Y') - date('Y', strtotime($this->dob));
       $this->get_renewal_category();

        $this->renewal_criteria = RenewalCriteria::where('renewal_category_id', $this->renewal_category_id)
            ->where('employment_status_id', $this->employment_status_id)
            ->where('employment_location_id', $this->employment_location_id)
            ->where('certificate_request', $this->certificate_request)->first();

    }

    public function render()
    {

        return view('livewire.create-renewal', [
            'employment_statuses' => EmploymentStatus::all(),
            'employment_locations' => EmploymentLocation::all(),

            /* 'renewal_fee'=> RenewalCriteria::where('employment_status_id',$this->employment_status_id)
                            ->where('employment_location_id',$this->employment_location_id)->where('certificate_request',$this->certificate_request)->first()*/

        ]);
    }
}
