<?php

namespace App\Http\Livewire\Dashboard\Contract;

use App\Models\Contract\Contract;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $method;


    public function render()
    {
        $contracts = Contract::paginate(10);
        return view('livewire.dashboard.contract.index', [
            'contracts' => $contracts,
        ]);
    }
}
