<?php

namespace App\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Bidding\BiddingItem;
use App\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Item extends Component
{
    use LivewireAlert;
    protected $listeners = ['destroyItem' => 'destroyItem'];
    public Bidding $bidding;

    public $sequence;
    public $method;
    public $description;
    public $catmat;
    public $unity;
    public $quantity;
    public $estimated_total_value;

    public $itemEdit;

    protected $rules =  [
        'description' => 'required|min:4|max:2500',
        'catmat' => 'nullable|integer',
        'unity' => 'required',
        'quantity' => 'required',
        'estimated_total_value'=> 'nullable',
    ];
    protected $validationAttributes = [
        'description' => '[Descrição]',
        'catmat' => '[CATMAT]',
        'unity' => '[Unidade]',
        'quantity' => '[Quantidade]',
        'estimated_total_value'=> '[Valor total estimado]',
    ];
    public function mount($bidding)
    {
        $this->bidding = $bidding;
        $this->biddingItens = BiddingItem::where('bidding_id',  $bidding->id)->get();


    }
    public function resetAttributes(){
        $this->reset([
            'description',
            'catmat',
            'unity',
            'quantity',
            'estimated_total_value',
            'itemEdit',
            'method'
        ]);
    }
    public function create()
    {
        $this->resetAttributes();
        $this->method = 0;
        $item = BiddingItem::where('bidding_id', $this->bidding->id)->max('item');

        if($item){
            #
            $this->sequence = $item + 1;
        }
        else{
            $this->sequence = 1;
        }
        $this->dispatchBrowserEvent('open-form-item');
    }
    public function store()
    {
        $dataForm = $this->validate();
        $dataForm['item'] = $this->sequence;
        $dataForm['bidding_id'] = $this->bidding->id;

        $save = BiddingItem::create($dataForm);

        $dataForm['estimated_total_value'] = ($dataForm['estimated_total_value']!=null) ? $dataForm['estimated_total_value'] : 0;

        $this->resetAttributes();
        $this->dispatchBrowserEvent('close-form-item');

        if($save)
        {

            $this->alert('success', 'Item criado com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao criar o item!');
        }
    }

    public function edit($id)
    {
        $this->resetAttributes();
        $this->method = 1;
        $this->itemEdit = $this->bidding->biddingItens()->find($id);
        $this->sequence = $this->itemEdit->item;
        $this->description = $this->itemEdit->description;
        $this->catmat = $this->itemEdit->catmat;
        $this->unity = $this->itemEdit->unity;
        $this->quantity = $this->itemEdit->quantity;
        $this->estimated_total_value = $this->itemEdit->estimated_total_value;

        $this->dispatchBrowserEvent('open-form-item');

    }
    public function update()
    {
        $dataForm =  $this->validate();
        $dataForm['estimated_total_value'] = ($dataForm['estimated_total_value']!=null) ? $dataForm['estimated_total_value'] : 0;
        $update = $this->itemEdit->update($dataForm);
        $this->resetAttributes();
        $this->dispatchBrowserEvent('close-form-item');
        if($update)
        {

            $this->alert('success', 'Item atualizado com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao atualizar o item!');
        }
    }
    public function delete($id){
        $this->itemEdit = $this->bidding->biddingItens()->find($id);
        $this->dispatchBrowserEvent('open-form-item-delete');
    }
    public function destroyItem()
    {
        $delete = $this->itemEdit->delete();
        $this->resetAttributes();
        if($delete)
        {

            $this->alert('success', 'Item removido com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao remover o item!');
        }
    }
    public function render()
    {

        $unityList = Category::where('type','bidding_unity')
        ->where('status', true)->pluck('category');
        $biddingItens = BiddingItem::where('bidding_id',  $this->bidding->id)->orderBy('item', 'ASC')->get();

        return view('livewire.dashboard.bidding.item', [
            'unityList' => $unityList,
            'biddingItensA' => $biddingItens,
        ]);
    }
}
