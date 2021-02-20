<?php

namespace App\Http\Livewire;

use App\Practitioner;
use Livewire\Component;
use Livewire\WithPagination;

class Pending extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;
    public $compliance = 0;


    public function render()
    {
        return view('livewire.pending', [
            'practitioners' => Practitioner::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->CheckCompliance($this->compliance)
                ->where('approval_status',0)
                ->paginate($this->perPage),
        ]);
    }
}
