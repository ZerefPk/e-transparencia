<?php

namespace App\Http\Livewire\Dashboard\Publication;

use App\Models\Publication\PublicationTemplate;
use Livewire\Component;

class Management extends Component
{

    public PublicationTemplate $publication;

    public function mount($id)
    {
        $this->publication = PublicationTemplate::findOrFail($id);
        if(!$this->publication){
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.publication.management');
    }
}
