<?php

namespace App\Http\Livewire;


use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Profession;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Livewire\Component;
use Carbon\CarbonInterval;
class CreateRenewal extends Component
{

    public $professions;
    public $practitioner;
    public $employment_status_id;
    public $employment_location_id;
    public $certificate_request;
    public $dob;
    public $age;
    public $profession;
    public $created_at;


    public function mount(){
        $this->dob  = $this->practitioner->dob;
    }
    public function render()
    {

        $this->age = date('Y') - date('Y',strtotime($this->dob));
        return view('livewire.create-renewal',[
            'employment_statuses'=>EmploymentStatus::all(),
            'employment_locations'=>EmploymentLocation::all(),
        ]);
    }
}
