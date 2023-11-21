<?php

namespace App\Livewire\Dashboard\Contract;

use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractDocument;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Document extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['destroy' => 'destroy'];

    public Contract $contract;

    public $documetDestroy;

    public $name;
    public $description;
    public $document;


    protected $rules = [
            'name' => 'required|min:2|max:254',
            'description' => 'nullable|min:2|max:400',
            'document' => 'required|file',
        ];

    public $validationAttributes = [
            'name' => '[Nome do arquivo]',
            'description' => '[Descrição]',
            'document' => '[Documento]',
        ];

    public function mount($contract)
    {
        $this->contract = $contract;

    }
    public function resetAttributes(){
        $this->reset(['name', 'description', 'document']);
        $this->dispatch('clearInput');
    }

    public function store()
    {
        $this->validate();
        $path = "{$this->contract->year}/{$this->contract->number}/";


        $document = ContractDocument::create([
            'name' => $this->name,
            'path' => $path,
            'description' => $this->description,
            'contract_id' => $this->contract->id,
        ]);

        if ($document) {
            $extension = $this->document->extension();
            $document->extension = '.'.$extension;
            $document->save();
            $path = $this->document->storeAs('contract/'.$path, $document->slug.'.'.$extension, 'public');

            if ($path) {
                $this->resetAttributes();
                $this->alert('success', 'Documento incluido com sucesso');

            }
            else{
                $this->resetAttributes();

                $this->alert('success', 'Houve um erro ao incluir documento na Licitação!');
                $document->delete();
            }

        }

    }
    public function delete($id)
    {
        $document = $this->contract->documents->find($id);

        if($document)
        {
            $this->documetDestroy = ContractDocument::find($id);
            $this->dispatch('delete-document', ['name' => $document['name']]);
        }
        else{
            $this->alert('error', "Houve um erro selecionar o documento!");
        }
    }
    public function destroy()
    {

        $path = Storage::delete('contract/'.$this->documetDestroy->path.$this->documetDestroy->slug.$this->documetDestroy->extension);
        if($path){

            $delete = $this->documetDestroy->delete();
            if($delete){
                $this->reset('documetDestroy');
                $this->alert('success', 'Arquivo removido');

            }
            else{
                $this->alert('error', 'Houve um erro ao remover o arquivo');
            }
        }
        else{
            $this->alert('error', 'Houve um erro ao remover o arquivo');
        }

    }
    public function render()
    {
        $documentsList = Category::where('type','contract_document')->where('status', true)->pluck('category');

        $contractDocuments = ContractDocument::where('contract_id', $this->contract->id)->get();
        return view('livewire.dashboard.contract.document', [
            'documentsList' => $documentsList,
            'contractDocuments' => $contractDocuments,
        ]);
    }

}
