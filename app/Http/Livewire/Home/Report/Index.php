<?php

namespace App\Http\Livewire\Home\Report;

use App\Models\Report\ReportTemplate;
use App\Models\Year;
use Livewire\Component;

class Index extends Component
{
    public ReportTemplate $report;

    public function mount($report)
    {
        $this->report = $report;
    }
    public function render()
    {
        $years = Year::where('status', 1)->orderBy('year', 'DESC')->get();
        return view('livewire.home.report.index',[
            'years' => $years,
        ])->layout('layouts.app');
    }
}
