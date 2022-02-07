<?php

namespace App\Http\Livewire\Home\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdvancedQuery extends Component
{
    use WithPagination, LivewireAlert;

    public $a;
    public $t;
    public $n;
    public $e;
    public $aI;
    public $tI;
    public $nI;
    public $eI;

    public $listSearch = array();
    public $method = 0;

    public $queryString = [
        'a' =>  ['except' => ''],
        'e' =>  ['except' => ''],
        't' =>  ['except' => ''],
        'n' =>  ['except' => '']
    ];
    protected $rules = [
        'aI' => 'nullable',
        'eI' => 'nullable',
        'tI' => 'nullable',
        'nI' => 'nullable',
    ];
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
        if(isset($this->n) && $this->n != "")
        {
            $query->where('number', 'like' ,$this->n."%");
            $this->listSearch['ementa'] = ['field' =>'Ementa', 'value' => $this->e];
        }
        if(isset($this->t) && $this->t != ""){
            $type = TypeNormativeAct::where('slug', $this->t)->first();
            $query->where('type_id',  $type->id);
            $this->listSearch['type'] = ['field' =>'Tipo', 'value' =>  $type->plural];
        }
        $query->orderBy('number', "DESC");


        return $query;
    }
    public function checkQuery()
    {
        if(isset($this->a) && $this->a != ""  || isset($this->e) && $this->e != "" || isset($this->e) && $this->e != "" || isset($this->t) && $this->t != ""){
            $this->method = 1;

            return $this->query()->paginate(10);
        }

        return [];
    }
    public function setAttr()
    {
        $data = $this->validate();

        $nullable = 0;
        foreach($data as $item){

            if($item != null || $item != ''){
                $nullable++;
            }


        }
        if($nullable == 0 && !$this->method)
        {
            $this->alert('warning', 'PREENCHA UM DOS CAMPOS', [
                'toast' => false,
                'position' => 'center',
            ]);
        }

        $this->a = $data['aI'];
        $this->t = $data['tI'];
        $this->n = $data['nI'];
        $this->e = $data['eI'];
    }
    public function refreshQuery()
    {
        $this->reset();
        $this->method = 0;
    }
    public function render()
    {
        $types = TypeNormativeAct::where('status', true)->get();

        $normativesActs = $this->checkQuery();


        return view('livewire.home.normative-act.advanced-query', [
            'types' => $types,
            'normativesActs' => $normativesActs,
        ])->layout('layouts.app');
    }

}
