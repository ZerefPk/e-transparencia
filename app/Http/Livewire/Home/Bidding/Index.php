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
    protected $renderBidding = false;
    public $bidding;
    public $yearActive;
    public $listSearch = array();

    public $q;
    public $modalidade;
    public $situacao;
    public $tipo;

    public $queryString = [
        'q' =>  ['except' => ''],
        'modalidade' =>  ['except' => ''],
        'situacao' =>  ['except' => ''],
        'tipo'=>  ['except' => '']
    ];
    public function updatingQ()
    {
        $this->gotoPage(1);
    }
    public function updatingModalidade()
    {
        $this->gotoPage(1);
    }
    public function updatingSituacao()
    {
        $this->gotoPage(1);
    }
    public function updatingTipo()
    {
        $this->gotoPage(1);
    }

    public function search()
    {
        $biddings = Bidding::query();
        $biddings->where('year', $this->yearActive->year)->where('status', true);


        if (isset($this->q) && $this->q != "") {

            $biddings->where('number', 'like', '%'.$this->q)
            ->orWhere('object', 'like', '%'.$this->q.'%');
            $this->listSearch['q'] = ['field' => 'Busca' , 'value' => $this->q];
        }
        if (isset($this->modalidade) && $this->modalidade != "") {

            $category = Category::where('slug', $this->modalidade)->first();
            $biddings->where('modality_id', $category->id);

            $this->listSearch['modalidade'] = ['field' =>'Modalidade', 'value' => $category->category];
        }
        if (isset($this->tipo) && $this->tipo != "") {

            $category = Category::where('slug', $this->tipo)->first();
            $biddings->where('type_id', $category->id);

            $this->listSearch['tipo'] = ['field' =>'Tipo', 'value' => $category->category];
        }
        if (isset($this->situacao) && $this->situacao != "") {

            $category = Category::where('slug', $this->situacao)->first();
            $biddings->where('situation_id', $category->id);

            $this->listSearch['situacao'] = ['field' =>'Situação', 'value' => $category->category];
        }

        $biddings = $biddings->orderBy('number', 'ASC');

        return $biddings;



    }
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

                $this->bidding = Bidding::where('slug', $data)->first();
                if($this->bidding){

                    $this->renderBidding = true;
                }
                else{
                    abort(404);
                }
            }
        }

    }
    public function resetAttr()
    {
        $this->reset(['q', 'modalidade', 'situacao','tipo']);
        $this->listSearch = array();
    }
    public function render()
    {
        if(!$this->renderBidding){
            $years = Year::orderBy('year', 'DESC')->where('status', true)->limit(4)->get();
            $categories = Category::where('status', true)->where('type','like','bidding_%' )->get();
            $biddings = $this->search();
            return view('livewire.home.bidding.index',[
                'years' =>  $years,
                'categories' => $categories,
                'biddings' => $biddings->paginate(15),
            ])->layout('layouts.app');
        }
        else{

            return view('livewire.home.bidding.details',[
                'biddings' => $this->bidding,
            ])->layout('layouts.app');
        }
    }
}
