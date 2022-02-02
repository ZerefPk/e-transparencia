<?php

namespace App\Http\Livewire\Home\Contract;

use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $a;
    public $q;
    public $f;
    public $s;

    public $listSearch = array();

    public $queryString = ['a' =>  ['except' => ''],'q' =>  ['except' => ''],
    'f' =>  ['except' => ''], 's' =>  ['except' => '']] ;

    public function updatingA()
    {
        $this->gotoPage(1);
    }
    public function updatingQ()
    {
        $this->gotoPage(1);
    }
    public function updatingF()
    {
        $this->gotoPage(1);
    }
    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function refreshQuery()
    {
        $this->reset(['a','q','f','s']);
    }
    public function query()
    {
        $query = Contract::query();
        $query->where('contracts.status', true);

        if(isset($this->a) && $this->a != ""){
            $query->where('contracts.year', $this->a);
            $this->listSearch['year'] = ['field' =>'Ano', 'value' => $this->a];
        }
        if(isset($this->q) && $this->q != ""){


            $query->join('providers', 'contracts.provider_id','providers.id')
            ->where('providers.corporate_name', 'like', $this->q.'%')->orWhere('contracts.number', 'like' ,$this->q.'%')
            ->orWhere('contracts.object', 'like' , $this->q.'%');;
            $this->listSearch['search'] = ['field' =>'Busca', 'value' => $this->q];

        }
        if(isset($this->s) && $this->s != ""){
            $category = Category::where('slug', $this->s)->first();
            $query->where('contracts.situation_id', $category->id);
            $this->listSearch['situation'] = ['field' =>'Situação', 'value' => $category->category];
        }
        if(isset($this->f) && $this->f != ""){
            $category = Category::where('slug', $this->f)->first();
            $query->where('contracts.subject_id', $category->id);
            $this->listSearch['subejct'] = ['field' =>'Assunto', 'value' => $category->category];

        }

        $query->orderBy('year', 'DESC');
        return $query;
    }
    public function render()
    {
        $contracts = $this->query()->paginate(10);
        $situations = Category::where('type', 'contract_situation')->where('status', true)->orderBy('type', 'ASC')->get();
        $subjects = Category::where('type', 'contract_subject')->where('status', true)->orderBy('type', 'ASC')->get();
        $years = Year::where('status', true)->orderBy('year', 'DESC')->get();
        return view('livewire.home.contract.index', [
            'contracts' => $contracts,
            'situations' => $situations,
            'subjects' => $subjects,
            'years' => $years,
        ])->layout('layouts.app');
    }
}
