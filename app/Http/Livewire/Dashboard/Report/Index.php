<?php

namespace App\Http\Livewire\Dashboard\Report;

use App\Models\Report\ReportTemplate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $title;
    public $status;
    public $description;
    public $q;
    public $s;
    public $method;

    public $rules = [
        'title' => 'required|min:3|max:18',
        'description' => 'nullable|min:5|max:2500',
        'status' => 'required',
    ];
    public $validationAttributes = [
        'title' => '[Titulo]',
        'description' => '[Descrição]',
        'status' => '[Status]',
    ];

    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function updatingQ()
    {
        $this->gotoPage(1);
    }

    public function query()
    {
        $query = ReportTemplate::query();
        if(isset($this->q) && $this->q != "");
        {
            $query->where('title', 'like', $this->q.'%');
        }
        if(isset($this->s) && $this->s != "")
        {
            $query->where('status', $this->s);
        }
        $query->orderBy('title', 'ASC');
        return $query;
    }

    public function render()
    {
        $templates = $this->query()->paginate(10);
        return view('livewire.dashboard.report.index', [
            'templates' => $templates
        ]);
    }
}
