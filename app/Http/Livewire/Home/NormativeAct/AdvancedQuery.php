<?php

namespace App\Http\Livewire\Home\NormativeAct;

use App\Models\NormativeAct\TypeNormativeAct;
use Livewire\Component;

class AdvancedQuery extends Component
{
    public function render()
    {
        $types = TypeNormativeAct::where('status', true)->get();
        return view('livewire.home.normative-act.advanced-query', [
            'types' => $types,
        ])->layout('layouts.app');
    }

}
