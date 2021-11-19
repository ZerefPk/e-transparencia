<?php

namespace App\Http\Livewire\Home\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $yearActive;

    public $q;
    public $modalidade;
    public $situacao;
    public $tipo;

    public $queryString = ['q'];

    public function mount($data = null){

        if ( is_null($data)) {
            $this->yearActive = Year::where('primary', true)->first();
            if (!$this->yearActive)
            {
                abort(404);
            }
        }
        else{
            $this->yearActive = Year::where('year', $data)->first();
            if (!$this->yearActive) {
                abort(404);
            }


        }

    }
    public function render()
    {
        $years = Year::orderBy('year', 'DESC')->where('status', true)->limit(4)->get();
        $categories = Category::where('status', true)->where('type','like','bidding_%' )->get();
        $biddings = Bidding::where('year',$this->yearActive->year)->orderBy('number', 'ASC')->where('status', true)->paginate(20);

        return view('livewire.home.bidding.index',[
            'years' =>  $years,
            'categories' => $categories,
            'biddings' => $biddings,
        ])->layout('layouts.app');
    }
}
