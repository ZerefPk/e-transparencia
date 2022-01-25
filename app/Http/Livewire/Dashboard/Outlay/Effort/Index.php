<?php

namespace App\Http\Livewire\Dashboard\Outlay\Effort;

use App\Models\Outlay\Effort;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $y;
    public $n;
    public $f;
    public $s;


    public $queryString = ['y','n','f','s'];

    public function updatingY()
    {
        $this->gotoPage(1);
    }
    public function updatingN()
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
    public function query()
    {
        $query = Effort::query();

        if(isset($this->y) && $this->y != ""){
            $query->where('efforts.year', $this->y);
        }
        if(isset($this->n) && $this->n != ""){
            $query->where('efforts.number', $this->n);
        }
        if(isset($this->f) && $this->f != ""){

            $query->join('providers', 'efforts.provider_id','providers.id')->where('providers.corporate_name', 'like', $this->f.'%');
        }
        if(isset($this->s) && $this->s != ""){
            $query->where('efforts.status', $this->s);
        }

        $query->orderBy('year', 'DESC')->orderBy('number', 'ASC');
        return $query;
    }
    public function refreshQuery()
    {
        $this->reset(['y','n','f','s']);
    }
    public function render()
    {
        $efforts = $this->query()->paginate(10);
        $years = Year::where('status', true)->orderBy('year', 'DESC')->get();
        return view('livewire.dashboard.outlay.effort.index', [
            'years' => $years,
            'efforts' => $efforts
        ]);
    }
}
