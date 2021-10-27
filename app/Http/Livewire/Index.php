<?php

namespace App\Http\Livewire;

use App\Practitioner;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $compliance;


    public function render()
    {
        //dd($practitioner->practitioner_payment_information);
        return view('livewire.index', [
            'practitioners' => Practitioner::search($this->search)
                ->CheckCompliance($this->compliance)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ]);
    }
}
