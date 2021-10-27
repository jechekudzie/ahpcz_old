<?php

namespace App\Http\Livewire;

use App\Practitioner;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;


class Student extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $compliance;
    public $register_category = 1;


    public function render()
    {
        return view('livewire.student', [
            'practitioners' => Practitioner::student($this->search)
                ->Register($this->register_category)
                ->CheckCompliance($this->compliance)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ]);
    }
}
