<?php

namespace App\Http\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use Livewire\Component;

class Details extends Component
{
    public NormativeAct $normativeAct;

    public function mount($id)
    {
        $this->normativeAct = NormativeAct::find($id);
    }
    public function render()
    {
        return view('livewire.dashboard.normative-act.details');
    }
}
