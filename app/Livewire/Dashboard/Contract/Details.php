<?php

namespace App\Livewire\Dashboard\Contract;

use App\Models\Contract\Contract;
use Livewire\Component;

class Details extends Component
{
    public Contract $contract;

    public function mount($contract)
    {

        $this->contract = $contract;
    }
    public function render()
    {
        return view('livewire.dashboard.contract.details');
    }
}
