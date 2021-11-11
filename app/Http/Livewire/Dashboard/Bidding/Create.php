<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    public $bidding;

    public function render()
    {
        return view('livewire.dashboard.bidding.create');
    }
}
