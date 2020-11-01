<?php

namespace App\Http\Livewire;

use App\Practitioner;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class Pendings extends Component
{
    use WithPagination;

    public $searchTerm;
    public $currentPage = 1;

    public function render()
    {
        /* $query = '%' . $this->searchTerm . '%';
         $query = '%' . $this->searchTermPending . '%';*/

        return view('livewire.index', [
            'practitioners' => Practitioner::where('approval_status', '=', 0)->where(function ($sub_query) {
                $sub_query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');

            })->paginate(10),

        ]);


    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

}
