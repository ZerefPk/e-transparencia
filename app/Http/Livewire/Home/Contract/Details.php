<?php

namespace App\Http\Livewire\Home\Contract;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractEffort;
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
        $efforts = ContractEffort::where('contract_id', $this->contract->id)->orderBy('date_effort')->get();
        return view('livewire.home.contract.details',[
            'efforts' => $efforts,
        ])->layout('layouts.app');
    }
}
