<?php

namespace App\Livewire\Home\Bidding;

use App\Models\Year;
use Livewire\Component;

class Others extends Component
{
    public function render()
    {

        $years = Year::where('status', true)->orderBy('year', 'DESC')->get();
        return view('livewire.home.bidding.others',[
            'years' => $years,
        ])->layout('layouts.app');
    }
}
