<?php

namespace App\Http\Livewire\Home\Contract;

use App\Models\Contract\Contract;
use Livewire\Component;

class Index extends Component
{

    public function render()
    {
        $contracts = Contract::all();
        return view('livewire.home.contract.index');
    }
}
