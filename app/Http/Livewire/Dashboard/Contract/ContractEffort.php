<?php

namespace App\Http\Livewire\Dashboard\Contract;

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
    public $effort_id;
    public $document;


    protected $rules = [
            'number_effort' => 'required|min:2|max:254',
            'effort_id' => 'nullable',
            'document' => 'required|file',
        ];

    public $validationAttributes = [
            'number_effort' => '[Nome do arquivo]',
            'effort_id' => '[Descrição]',
            'document' => '[Documento]',
        ];

    public function mount($contract)
    {
        $this->contract = $contract;

    }
    public function resetAttributes(){
        $this->reset(['number_effort', 'effort_id', 'document']);
        $this->dispatchBrowserEvent('clearInput');
    }

    public function store()
    {
        $this->validate();
        $path = "{$this->contract->year}/{$this->contract->number}/efforts/";


        $document = ModelContractEffort::create([
            'number_effort' => $this->number_effort,
            'path' => $path,
            'effort_id' => $this->effort_id,
            'contract_id' => $this->contract->id,
        ]);

        if ($document) {
            $extension = $this->document->extension();
            $document->extension = '.'.$extension;
            $document->save();
            $path = $this->document->storeAs('contract/'.$path, $document->slug_file.'.'.$extension, env('FILESYSTEM_DRIVER'));

            if ($path) {
                $this->resetAttributes();
                $this->dispatchBrowserEvent('clearInput');
                $this->alert('success', 'Empenho incluido com sucesso');

            }
            else{
                $this->resetAttributes();

                $this->alert('success', 'Houve um erro ao incluir o Empenho no contrato!');
                $document->delete();
            }

        }

    }
    public function delete($id)
    {
        $document = $this->contract->efforts->find($id);

        if($document)
        {
            $this->contractEffortSelect = ModelContractEffort::find($id);
            $this->dispatchBrowserEvent('delete-effort', ['number_effort' => $document['number_effort']]);
        }
        else{
            $this->alert('error', "Houve um erro selecionar o Empenho!");
        }
    }
    public function destroy()
    {

        $path = Storage::delete('contract/'.$this->contractEffortSelect->path.$this->contractEffortSelect->slug.$this->contractEffortSelect->extension);
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
        $efforts = Effort::where('status', true)->get();

        $contractEfforts = ModelContractEffort::where('contract_id', $this->contract->id)->get();
        return view('livewire.dashboard.contract.contract-effort', [
            'efforts' => $efforts,
            'contractEfforts' => $contractEfforts,
        ]);
    }

}
