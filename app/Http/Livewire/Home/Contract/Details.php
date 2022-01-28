<?php

namespace App\Http\Livewire\Home\Contract;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractAmendment;
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
        $additives = ContractAmendment::where('contract_id', $this->contract->id)->orderBy('sequence', 'ASC')->get();
        return view('livewire.home.contract.details',[
            'efforts' => $efforts,
            'additives' => $additives,
        ])->layout('layouts.app');
    }
}
