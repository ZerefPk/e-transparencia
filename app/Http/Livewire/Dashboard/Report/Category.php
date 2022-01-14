<?php

namespace App\Http\Livewire\Dashboard\Report;

use App\Models\Report\ReportTemplate;
use App\Models\Report\ReportType;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public ReportTemplate $report;

    public $category;
    public $type;
    public $status;
    public $method;

    protected $rules = [
        'type' => 'required|min:1',
        'status' => 'required'
    ];
    protected $validationAttributes = [
        'type' => '[ Categória ]',
        'status' => '[ Status ]'
    ];

    public function mount($report)
    {
        $this->report = $report;
    }

    public function create()
    {
        $this->reset('type', 'method', 'status');
        $this->method=0;
        $this->dispatchBrowserEvent('open-form-category');
    }
    public function store()
    {
       $data = $this->validate();
       $data['report_template_id'] = $this->report->id;

       $save = ReportType::create($data);

       if($save){
        $this->reset(['type', 'method', 'status']);
        $this->dispatchBrowserEvent('close-form-category');

        $this->alert('success', "Categoria criada com sucesso!");
       }
       else{
        $this->alert('error', 'Houve um erro ao criar a categoria...');
       }

    }
    public function edit($id)
    {
        $this->reset(['type', 'method', 'status']);
        $this->category = ReportType::findOrFail($id);
        $this->type = $this->category->type;
        $this->status = $this->category->status;
        $this->method=1;
        $this->dispatchBrowserEvent('open-form-category');
    }
    public function update()
    {
       $data = $this->validate();

       $save = $this->category->update($data);

       if($save){
        $this->reset(['category','type', 'method', 'status','category']);
        $this->dispatchBrowserEvent('close-form-category');

        $this->alert('success', "Categoria atualizada com sucesso!");
       }
       else{
        $this->alert('error', 'Houve um erro ao atualizar a categoria...');
       }

    }
    public function render()
    {
        $categories = ReportType::where('report_template_id', $this->report->id)->paginate(10);
        return view('livewire.dashboard.report.category', [
           'categories' => $categories,
        ]);
    }
}
