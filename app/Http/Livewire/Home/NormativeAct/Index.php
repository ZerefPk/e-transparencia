<?php

namespace App\Http\Livewire\Home\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;

    public TypeNormativeAct $typeNormativeAct;

    public $a;
    public $e;

    public $listSearch = array();

    public $queryString = ['a' =>  ['except' => ''],'e' =>  ['except' => '']];

    public function updatingA()
    {
        $this->gotoPage(1);
    }
    public function updatingE()
    {
        $this->gotoPage(1);
    }
    public function query()
    {
        $query = NormativeAct::query();
        $query->where('status', true);
        if(isset($this->a) && $this->a != "")
        {
            $query->where('year', $this->a);
            $this->listSearch['year'] = ['field' =>'Ano', 'value' => $this->a];
        }
        if(isset($this->e) && $this->e != "")
        {
            $query->where('ementa', 'like' ,$this->e."%");
            $this->listSearch['ementa'] = ['field' =>'Ementa', 'value' => $this->e];
        }
        $query->orderBy('number', "DESC");

        return $query;
    }
    public function refreshQuery()
    {
        $this->reset(['a','e']);
    }
    public function mount($typeNormativeAct)
    {
        $this->typeNormativeAct = $typeNormativeAct;
    }
    public function render()
    {
        $years = Year::where('status', true)->get();
        $normativesActs = $this->query()->paginate(10);
        return view('livewire.home.normative-act.index', [
            'years' => $years,
            'normativesActs' => $normativesActs,
        ])->layout('layouts.app');
    }
}
