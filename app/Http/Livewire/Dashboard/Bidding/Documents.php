<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Bidding\BiddingDocument;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Documents extends Component
{
    use LivewireAlert, WithFileUploads;
    protected $listeners = ['destroy' => 'destroy'];
    public $name;
    public $description;
    public $document;
    public $documetDestroy;
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

    public function mount($bidding)
    {
        $this->bidding = $bidding;

    }
    public function resetAttributes(){
        $this->reset(['name', 'description', 'document']);
        $this->dispatchBrowserEvent('clearInput');
    }

    public function save()
    {
        $this->validate();
        $path = "{$this->bidding->year}/{$this->bidding->number}/";


        $document = BiddingDocument::create([
            'name' => $this->name,
            'path' => $path,
            'bidding_id' => $this->bidding->id,
        ]);

        if ($document) {
            //dd($this->document);
            $extension = $this->document->extension();
            $document->extension = '.'.$extension;
            $document->save();
            $path = $this->document->storeAs('bidding/'.$path, $document->slug.'.'.$extension, env('FILESYSTEM_DRIVER'));

            if ($path) {
                $this->resetAttributes();
                $this->biddingDocuments = $this->bidding->documents;
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

        $document = $this->bidding->documents->find($id);

        if($document)
        {
            $this->documetDestroy = BiddingDocument::find($id);
            $this->dispatchBrowserEvent('delete-document', ['name' => $document['name']]);
        }
        else{
            $this->alert('error', "Houve um erro selecionar o documento!");
        }
    }
    public function destroy()
    {

        $path = Storage::delete('bidding/'.$this->documetDestroy->path.$this->documetDestroy->slug.$this->documetDestroy->extension);
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
        $documentsList = Category::where('type','bidding_document')->where('status', true)->pluck('category');
        $biddingDocuments = BiddingDocument::where('bidding_id', $this->bidding->id)->get();

        return view('livewire.dashboard.bidding.documents', [
            'documentsList' => $documentsList,
            'biddingDocuments' => $biddingDocuments,
        ]);
    }
}
