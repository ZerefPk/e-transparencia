<?php

namespace App\Http\Livewire\Dashboard\Report;

use App\Models\Report\ReportTemplate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $report;
    public $title;
    public $status;
    public $description;
    public $q;
    public $s;
    public $method;

    public $queryString = ['s','q'];

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

    public function create()
    {
       $this->reset(['title', 'status', 'description', 'method']);
       $this->method = 0;
       $this->dispatchBrowserEvent('open-form');
    }
    public function store()
    {
        $data = $this->validate();

        $validate = ReportTemplate::where('title', $this->title)->get();
        if(count($validate) > 0)
        {
            $this->alert('error', 'Relatório já cadastrado!');
        }
        else{
            $save = ReportTemplate::create($data);
            if($save){
                $this->reset();
                $this->dispatchBrowserEvent('close-form');
                $this->alert('success', 'Relatório Cadastrado', [
                    'toast' => false,
                    'position' =>  'center'
                ]);

            }
            else{
                $this->alert('error', 'Houve um erro ao cadastrar o Relatório...');
            }

        }

    }
    public function edit($id)
    {
        $this->reset(['title', 'status', 'description', 'method']);
        $this->report = ReportTemplate::findOrFail($id);
        $this->title = $this->report->title;
        $this->status = $this->report->status;
        $this->description = $this->report->description;
        $this->method=1;
        $this->dispatchBrowserEvent('open-form');
    }
    public function update()
    {
        $data = $this->validate();

        $validate = ReportTemplate::where('title', $this->title)->where('id','!=', $this->report->id)->get();
        if(count($validate) > 0)
        {
            $this->alert('error', 'Relatório já cadastrado!');
        }
        else{
            $save = $this->report->update($data);
            if($save){
                $this->reset();
                $this->dispatchBrowserEvent('close-form');
                $this->alert('success', 'Relatório atualizado', [
                    'toast' => false,
                    'position' =>  'center'
                ]);

            }
            else{
                $this->alert('error', 'Houve um erro ao atualizar o Relatório...');
            }

        }

    }
    public function render()
    {
        $templates = $this->query()->paginate(10);
        return view('livewire.dashboard.report.index', [
            'templates' => $templates
        ]);
    }
}
