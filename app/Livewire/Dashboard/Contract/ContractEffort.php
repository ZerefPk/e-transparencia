<?php

namespace App\Livewire\Dashboard\Contract;

use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractEffort as ModelContractEffort;
use App\Models\Outlay\Effort;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContractEffort extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['destroyEffort' => 'destroy'];

    public Contract $contract;

    public $contractEffortSelect;

    public $number_effort;
    public $type_effort;
    public $total_value;
    public $date_effort;
    public $effort_id;
    public $document;


    protected $rules = [
            'number_effort' => 'required|min:2|max:254',
            'type_effort' => 'required',
            'total_value' => 'required',
            'effort_id' => 'nullable',
            'date_effort' => 'required|date',
            'document' => 'required|file',
        ];

    public $validationAttributes = [
            'number_effort' => '[Nome do arquivo]',
            'type_effort' => '[Tipo de empenho]',
            'total_value' => '[Valor total]',
            'date_effort' => '[Data do empenho]',
            'effort_id' => '[Descrição]',
            'document' => '[Documento]',
        ];

    public function setEffort()
    {

        if($this->effort_id != "")
        {
            $effort = Effort::find($this->effort_id);
            if($effort){
            $this->number_effort = $effort->getRealNumber();
            $this->total_value = $effort->total_value;
            $this->date_effort = $effort->date_effort;
            $this->type_effort = $effort->type;
            }
        }
    }
    public function mount($contract)
    {
        $this->contract = $contract;

    }
    public function resetAttributes(){
        $this->reset(['number_effort','type_effort' , 'total_value' ,'effort_id','date_effort', 'document']);
        $this->dispatch('clearInput');
    }
    public function create()
    {
        $this->resetAttributes();

        $this->dispatch('open-form-effort');

    }

    public function store()
    {
        $this->validate();
        $path = "{$this->contract->year}/{$this->contract->number}/efforts/";


        $document = ModelContractEffort::create([
            'number_effort' => $this->number_effort,
            'type_effort' => $this->type_effort,
            'total_value' => $this->total_value,
            'date_effort' => $this->date_effort,
            'path' => $path,
            'effort_id' => $this->effort_id,
            'contract_id' => $this->contract->id,
        ]);

        if ($document) {
            $extension = $this->document->extension();
            $document->extension = '.'.$extension;

            $document->save();
            $path = $this->document->storeAs('contract/'.$path, $document->slug_file.'.'.$extension, 'public');

            if ($path) {
                $this->resetAttributes();
                $this->dispatch('close-form-effort');
                $this->alert('success', 'Empenho incluido com sucesso');

            }
            else{
                $document->delete();


                $this->alert('success', 'Houve um erro ao incluir o Empenho no contrato!');

            }

        }

    }

    public function delete($id)
    {
        $document = $this->contract->efforts->find($id);

        if($document)
        {
            $this->contractEffortSelect = $document;
            $this->dispatch('delete-effort', ['number_effort' => $document['number_effort']]);
        }
        else{
            $this->alert('error', "Houve um erro selecionar o Empenho!");
        }
    }
    public function destroy()
    {

        $path = Storage::delete('contract/'.$this->contractEffortSelect->path.$this->contractEffortSelect->slug_file.$this->contractEffortSelect->extension);
        if($path){

            $delete = $this->contractEffortSelect->delete();
            if($delete){
                $this->reset('contractEffortSelect');
                $this->alert('success', 'Empenho removido');

            }
            else{
                $this->alert('error', 'Houve um erro ao remover o Empenho');
            }
        }
        else{
            $this->alert('error', 'Houve um erro ao remover o Empenho');
        }

    }
    public function render()
    {
        $efforts = Effort::where('contract_id', $this->contract->id)->where('status', true)->get();
        $typesEfforts = Effort::types();

        $contractEfforts = ModelContractEffort::where('contract_id', $this->contract->id)->orderBy('date_effort')->get();
        return view('livewire.dashboard.contract.contract-effort', [
            'efforts' => $efforts,
            'contractEfforts' => $contractEfforts,
            'typesEfforts' => $typesEfforts,
        ]);
    }

}
