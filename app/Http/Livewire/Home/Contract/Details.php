<?php

namespace App\Http\Livewire\Home\Contract;

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
        return view('livewire.home.contract.details')->layout('layouts.app');
    }
}
