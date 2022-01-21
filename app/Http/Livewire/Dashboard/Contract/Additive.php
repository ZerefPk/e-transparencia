<?php

namespace App\Http\Livewire\Dashboard\Contract;

use App\Models\Contract\Contract;
use App\Models\Contract\ContractAmendment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Additive extends Component
{
    use LivewireAlert;
    protected $listeners = ['destroyadditive' => 'destroyadditive'];

    public Contract $contract;
    public $method;
    public $sequence;
    public $description;
    public $type_modification;
    public $decrease_value;
    public $addition_value;
    public $termination_value;
    public $total_value;
    public $signature_date;
    public $start_validity;
    public $end_term;

    public $additiveEdit;

    protected $rules = [
        'description' => 'required|min:4|max:2500',
        'type_modification' => 'required',
        'decrease_value' => 'required_if:type_modification,2',
        'addition_value' => 'required_if:type_modification,1',
        'termination_value' => 'required_if:type_modification,3',
        'total_value' => 'required',
        'signature_date' => 'required',
        'start_validity' => 'nullable',
        'end_term' => 'nullable',
    ];
    protected $validationAttributes = [
        'description' => '[Descrição]',
        'type_modification' => '[Tipo de modificação]',
        'decrease_value' => '[Decréscimo]',
        'addition_value' => '[Acréscimo]',
        'termination_value'=> '[Rescisão]',
        'total_value'=> '[Valor total]',
        'signature_date' => '[Data da Assinatura]',
        'start_validity' => '[ Inicio da Vigência ]',
        'end_term'  => '[ Fim da Vigência ]',
    ];
    public function mount($contract)
    {
        $this->contract = $contract;
    }
    public function resetAttributes(){
        $this->reset([
            'description',
            'type_modification',
            'decrease_value',
            'addition_value',
            'termination_value',
            'total_value',
            'signature_date',
            'start_validity',
            'end_term',
            'method'
        ]);
    }
    public function create()
    {
        $this->method = 0;
        $this->resetAttributes();
        $sequence = ContractAmendment::where('contract_id', $this->contract->id)->max('sequence');

        if($sequence){
            #
            $this->sequence = $sequence + 1;
        }
        else{
            $this->sequence = 1;
        }
        $this->dispatchBrowserEvent('open-form-additive');
    }
    public function store()
    {
        $data = $this->validate();
        $data['sequence'] = $this->sequence;
        $data['contract_id'] = $this->contract->id;

        $save = ContractAmendment::create($data);

        $this->resetAttributes();
        $this->dispatchBrowserEvent('close-form-additive');

        if($save)
        {

            $this->alert('success', 'Aditivo criado com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao criar o aditivo!');
        }
    }

    public function edit($id)
    {
        $this->method = 1;
        $this->additiveEdit = $this->contract->additive()->find($id);


        $this->sequence = $this->additiveEdit->sequence;
        $this->description = $this->additiveEdit->description;
        $this->type_modification = $this->additiveEdit->type_modification;
        $this->decrease_value = $this->additiveEdit->decrease_value;
        $this->addition_value = $this->additiveEdit->addition_value;
        $this->termination_value = $this->additiveEdit->termination_value;
        $this->total_value = $this->additiveEdit->total_value;
        $this->signature_date = $this->additiveEdit->signature_date;
        $this->start_validity = $this->additiveEdit->start_validity;
        $this->end_term = $this->additiveEdit->end_term;

        $this->dispatchBrowserEvent('open-form-additive');

    }
    function update()
    {
        $data =  $this->validate();

        $update = $this->additiveEdit->update($data);
        $this->resetAttributes();
        $this->dispatchBrowserEvent('close-form-additive');
        if($update)
        {

            $this->alert('success', 'Aditivo atualizado com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao atualizar o aditivo!');
        }
    }
    public function delete($id){
        $this->additiveEdit = $this->contract->additive()->find($id);
        $this->dispatchBrowserEvent('open-form-additive-delete');
    }
    public function destroyadditive()
    {
        $delete = $this->additiveEdit->delete();
        $this->resetAttributes();
        if($delete)
        {

            $this->alert('success', 'Aditivo removido com sucesso!');
        }
        else{
            $this->alert('error', 'Houve um erro ao remover o aditivo!');
        }
    }
    public function render()
    {

        $contactAdditives = ContractAmendment::where('contract_id',  $this->contract->id)->orderBy('sequence', 'ASC')->get();
        return view('livewire.dashboard.contract.additive', [
            'contactAdditives' => $contactAdditives
        ]);
    }

}
