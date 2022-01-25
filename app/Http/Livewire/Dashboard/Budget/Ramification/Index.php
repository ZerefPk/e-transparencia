<?php

namespace App\Http\Livewire\Dashboard\Budget\Ramification;

use App\Models\Budget\BudgetRamification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $ramification;

    public $method;

    public $cod;
    public $description;
    public $type;
    public $project_id;
    public $status;

    public $c;
    public $d;
    public $t;
    public $s;

    public $queryString = ['c','d','t','s'];

    public $rules = [
        'cod' => 'required|min:2|max:255',
        'description' => 'required|min:2|max:255',
        'type' => 'required',
        'project_id' => 'required_if:type,2',
        'status' => 'required',
    ];
    public $validationAttributes = [
        'cod' => '[Código]',
        'description' => '[Descrição]',
        'type' => '[Tipo]',
        'project_id' => '[Projeto]',
        'status' => '[Status]'
    ];
    public function updatingC()
    {
        $this->gotoPage(1);
    }
    public function updatingD()
    {
        $this->gotoPage(1);
    }
    public function updatingT()
    {
        $this->gotoPage(1);
    }
    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function query()
    {
        $query = BudgetRamification::query();

        if(isset($this->c) && $this->c == ""){
            $query->where('cod', 'like',  $this->c.'%');
        }
        if(isset($this->d) && $this->d == ""){
            $query->where('description', 'like',  $this->d.'%');
        }
        if(isset($this->t) && $this->t == ""){
            $query->where('type',  $this->t);
        }
        if(isset($this->s) && $this->s == ""){
            $query->where('status',  $this->s);
        }

        $query->orderBy('type', 'ASC')->orderBy('cod', 'ASC');

        return $query;
    }
    public function resetAttr()
    {
        $this->reset([
            'cod',
            'description',
            'type',
            'status',
            'method',
            'ramification',
            'project_id'
        ]);
    }
    public function refreshQuery()
    {
        $this->reset();
    }
    public function create()
    {
        $this->resetAttr();
        $this->method = 0;
        $this->dispatchBrowserEvent('open-form');
    }
    public function store()
    {
        $data = $this->validate();
        $unique = BudgetRamification::where('cod' , $data['cod'])->first();

        if($unique && $unique->type == $this->type &&
        $this->project_id == $unique->project_id){
            $this->alert('error', 'Código já cadastrado...');
        }
        $unique = BudgetRamification::where('cod' , $data['cod'])
        ->where('project_id' , $data['project_id'])->first();

        if($unique)
        {
            $this->alert('error', 'Código já cadastrado...');
        }
        else{
            $save = BudgetRamification::create($data);

            if ($save) {
                if ($save) {

                    $this->alert('success', 'Desdobramento cadastrada!', [
                        'toast' => false,
                        'position' => 'center'
                    ]);

                    $this->resetAttr();
                    $this->dispatchBrowserEvent('close-form');
                }
                else{
                    $this->alert('error', 'Ocorreu um erro ao cadastar o Desdobramento...');

                }
            }
        }

    }
    public function edit($id)
    {
        $this->resetAttr();
        $this->method = 1;
        $this->ramification = BudgetRamification::find($id);
        $this->cod = $this->ramification->cod;
        $this->description = $this->ramification->description;
        $this->type = $this->ramification->type;
        $this->status = $this->ramification->status;
        $this->project_id = $this->ramification->project_id;
        $this->dispatchBrowserEvent('open-form');
    }
    public function update()
    {
        $data = $this->validate();

        $unique = BudgetRamification::where('cod' , $data['cod'])->first();
        if($unique && $unique->type == $this->type &&
        $unique->id != $this->ramification->id){
            $this->alert('error', 'Código já cadastrado...');
        }
        $unique = BudgetRamification::where('cod' , $data['cod'])
        ->where('project_id' , $data['project_id'])->first();

        if($unique && $unique->id != $this->ramification->id)
        {
            $this->alert('error', 'Código já cadastrado...');
        }
        else{
            if($this->type != 2)
            {
                $data['project_id'] = null;
            }
            $save = $this->ramification->update($data);
            if ($save) {
                if ($save) {

                    $this->alert('success', 'Desdobramento atualizado!', [
                        'toast' => false,
                        'position' => 'center'
                    ]);

                    $this->resetAttr();
                    $this->dispatchBrowserEvent('close-form');
                }
                else{
                    $this->alert('error', 'Ocorreu um erro ao atualizar o Desdobramento...');

                }
            }
        }

    }
    public function render()
    {
        $ramifications = $this->query()->paginate(10);
        $types = BudgetRamification::types();

        $projects = BudgetRamification::where('status', true)
        ->where('type', 1)->orderBy('cod', 'ASC')->get();
        return view('livewire.dashboard.budget.ramification.index', [
            'ramifications' => $ramifications,
            'types' => $types,
            'projects' => $projects,
        ]);
    }
}
