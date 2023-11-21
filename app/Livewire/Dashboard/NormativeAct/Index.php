<?php

namespace App\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $y;
    public $n;
    public $t;
    public $s;

    public $queryString = ['y','n','t','s'];
    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function updatingY()
    {
        $this->gotoPage(1);
    }
    public function updatingN()
    {
        $this->gotoPage(1);
    }
    public function updatingT()
    {
        $this->gotoPage(1);
    }
    public function query()
    {
        $query = NormativeAct::query();

        if(isset($this->y) && $this->y !="")
        {
            $query->where('normatives_acts.year', $this->y);
        }
        if(isset($this->n) && $this->n !=""){
            $query->where('normatives_acts.number','like' , $this->n.'%');
        }
        if(isset($this->s) && $this->s !=""){
            $query->where('normatives_acts.status', $this->s);
        }
        if(isset($this->t) && $this->t !=""){
            $query->join('types_normatives_acts', 'normatives_acts.type_id', 'types_normatives_acts.id' )->where('types_normatives_acts.slug', $this->t);
        }
        $query->orderBy('normatives_acts.type_id', 'ASC');

        return $query;
    }
    public function refreshQuery()
    {
        $this->reset(['t','s']);
    }
    public function render()
    {
        $years = Year::where('status', true)->get();
        $types = TypeNormativeAct::where('status', true)->get();
        $normativesActs = $this->query()->paginate(10);
        return view('livewire.dashboard.normative-act.index', [
            'years' => $years,
            'types' => $types,
            'normativesActs' => $normativesActs,
        ]);
    }
}
