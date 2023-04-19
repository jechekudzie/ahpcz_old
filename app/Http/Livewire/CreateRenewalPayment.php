<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateRenewalPayment extends Component
{

    public $profession;

    protected $listeners = ['refreshChildren' => '$refresh'];
    public function mount ($profession){

        $this->profession = $profession;
    }


    public function render()
    {
        return view('livewire.create-renewal-payment');
    }
}
