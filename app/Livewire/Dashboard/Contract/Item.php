<?php

namespace App\Livewire\Dashboard\Contract;

use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractItem;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Item extends Component
{
    use LivewireAlert;
    protected $listeners = ['destroyItem' => 'destroyItem'];
    public Contract $contract;
    public $method;
    public $sequence;

    public $description;
    public $catmat;
    public $unity;
    public $quantity;
    public $unity_value;
    public $total_value;

    public $itemEdit;

    protected $rules =  [
        'description' => 'required|min:4|max:2500',
        'unity' => 'required',
        'quantity' => 'required',
        'unity_value'=> 'required',
        'total_value'=> 'required',
    ];
    protected $validationAttributes = [
        'description' => '[Descrição]',
        'catmat' => '[CATMAT]',
        'unity' => '[Unidade]',
        'quantity' => '[Quantidade]',
        'total_value'=> '[Valor unitário]',
        'total_value'=> '[Valor total]',
    ];
    public function mount($contract)
    {
        $this->contract = $contract;
    }
    public function resetAttributes(){
        $this->reset([
            'description',
            'unity',
            'quantity',
            'unity_value',
            'total_value',
            'itemEdit',
            'method'
        ]);
    }
    public function create()
    {
        $this->resetAttributes();
        $this->method = 0;
        $item = ContractItem::where('contract_id', $this->contract->id)->max('item');

        if($item){
            #
            $this->sequence = $item + 1;
        }
        else{
            $this->sequence = 1;
        }
        $this->dispatch('open-form-item');
    }
    public function store()
    {
        $dataForm = $this->validate();
        $dataForm['item'] = $this->sequence;
        $dataForm['contract_id'] = $this->contract->id;

        $save = ContractItem::create($dataForm);

        $this->resetAttributes();
        $this->dispatch('close-form-item');

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
        $this->method = 1;
        $this->itemEdit = $this->contract->contractItens()->find($id);
        $this->sequence = $this->itemEdit->item;
        $this->description = $this->itemEdit->description;
        $this->unity = $this->itemEdit->unity;
        $this->quantity = $this->itemEdit->quantity;
        $this->unity_value = $this->itemEdit->unity_value;
        $this->total_value = $this->itemEdit->total_value;

        $this->dispatch('open-form-item');

    }
    public function update()
    {
        $dataForm =  $this->validate();

        $update = $this->itemEdit->update($dataForm);
        $this->resetAttributes();
        $this->dispatch('close-form-item');
        if($update)
        {

            $this->alert('success', 'Item atualizado com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao atualizar o item!');
        }
    }
    public function delete($id){
        $this->itemEdit = $this->contract->contractItens()->find($id);
        $this->dispatch('open-form-item-delete');
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
        $unityList = Category::where('type','contract_unity')
        ->where('status', true)->pluck('category');
        $contractItens = ContractItem::where('contract_id',  $this->contract->id)->orderBy('item', 'ASC')->get();
        return view('livewire.dashboard.contract.item', [
            'unityList' => $unityList,
            'contractItens' => $contractItens
        ]);
    }

}
