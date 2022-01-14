<?php

namespace App\Http\Livewire\Dashboard\Report;

use App\Models\Report\ReportTemplate;
use Livewire\Component;

class Management extends Component
{

    public ReportTemplate $report;

    public function mount($id)
    {
        $this->report = ReportTemplate::findOrFail($id);
        if(!$this->report){
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.report.management');
    }
}
