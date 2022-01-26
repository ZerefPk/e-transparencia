<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Bidding\BiddingItem;
use App\Models\Bidding\BiddingWin as BiddingBiddingWin;
use App\Models\Provider\Provider;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BiddingWin extends Component
{
    use LivewireAlert;
    public Bidding $bidding;

    protected $listeners = ['destroyWin' => 'destroyWin'];

    public $bidding_item_id;
    public $provider_id;
    public $approved_value;

    public $delete;

    public $rules = [
        'bidding_item_id' => 'required',
        'provider_id' => 'required',
        'approved_value' => 'nullable',
    ];

    public $validationAttributes = [

        'bidding_item_id' => '[Item]',
        'provider_id' => '[Fornecedor]',
        'approved_value' => '[Valor homologado]'

    ];

    public function mount($bidding)
    {
        $this->bidding = $bidding;
    }
    public function resetAttributes(){
        $this->reset([
            'bidding_item_id',
            'provider_id',
            'delete',
        ]);
    }
    public function create()
    {
        $this->dispatchBrowserEvent('open-form-win');
    }
    public function store()
    {
        $data = $this->validate();
        $data['bidding_id'] = $this->bidding->id;
        $save = BiddingBiddingWin::create($data);
        $this->resetAttributes();
        $this->dispatchBrowserEvent('close-form-win');

        if($save)
        {
            $this->alert('success', 'criado com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao criar!');
        }
    }
    public function delete($id){

        $this->delete = $this->bidding->wins()->find($id);
        $this->dispatchBrowserEvent('open-form-win-delete');
    }
    public function destroyWin()
    {
        $delete = $this->delete->delete();
        $this->resetAttributes();
        if($delete)
        {

            $this->alert('success', 'Removido com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao remover!');
        }
    }
    public function render()
    {

        $providers = Provider::where('status', true)->orderBy('corporate_name', 'ASC')->get();
        $itens = BiddingItem::where('bidding_id', $this->bidding->id)->orderBy('item', 'ASC')
                    ->get();

        $wins = BiddingBiddingWin::where('bidding_id', $this->bidding->id)
                ->orderBy('id', 'ASC')->get();


        return view('livewire.dashboard.bidding.bidding-win', [
            'providers' => $providers,
            'itens' => $itens,
            'wins' => $wins,

        ]);
    }
}
