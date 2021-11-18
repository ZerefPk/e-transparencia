<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use Livewire\Component;

class Details extends Component
{
    public Bidding $bidding;

    public function mount($id)
    {
        $this->bidding = Bidding::find($id);
        if(!$this->bidding){
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.bidding.details');
    }
}
