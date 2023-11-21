<?php

namespace App\Livewire\Dashboard\Publication;

use App\Models\Publication\PublicationDocument;
use App\Models\Publication\PublicationTemplate;
use App\Models\Publication\PublicationType;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Document extends Component
{

    use WithFileUploads,WithPagination,LivewireAlert;

    public PublicationTemplate $publication;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['destroy' => 'destroy'];

    public $types;
    public $documetDestroy;
    public $year;
    public $publication_date;
    public $type_id;
    public $document;
    public $description;

    protected $rules = [
        'year' => 'required',
        'publication_date'  => 'required|date',
        'type_id'  => 'required',
        'document'  => 'required|file|mimes:pdf',
        'description'  => 'nullable|min:5|max:255',
    ];
    protected $validationAttributes = [
        'year' => '[ Ano ]',
        'publication_date' => '[ Publicação ]',
        'type_id' => '[ Categoria ]',
        'document' =>' [ Arquivo [PDF] ]',
        'description' => '[ Descrição ]',
    ];
    public function mount($publication)
    {
        $this->publication = $publication;
    }
    public function create()
    {
        $this->dispatchBrowserEvent('open-form-report');

    }
    public function store()
    {
        $data = $this->validate();
        $path = "{$this->publication->title}/{$this->year}/";


        $save = PublicationDocument::create([
            'path' => $path,
            'publication_date' => $this->publication_date,
            'description' => $this->description,
            'publication_template_id' => $this->publication->id,
            'publication_type_id' => $this->type_id,
            'year' => $this->year,
        ]);

        if ($save) {
            $nameFile = "{$save->type->slug}-{$save->slug}";
            $extension = $this->document->extension();
            $save->extension = '.'.$extension;
            $save->slug =  Str::limit($nameFile, '254', '') ;
            $save->save();


            $path = $this->document->storeAs('publication/'.$path, $save->slug.'.'.$extension, env('FILESYSTEM_DRIVER'));

            if ($path) {
                $this->dispatchBrowserEvent('close-form-report');
                $this->reset([ 'year','publication_date' ,'type_id','document', 'description']);
                $this->alert('success', 'Publicação incluida com sucesso');
            }
            else{


                $this->alert('success', 'Houve um erro ao incluir publicação...');
                $save->delete();
            }

        }
    }
    public function delete($id)
    {
        $document = $this->publication->documents->find($id);

        if($document)
        {
            $this->documetDestroy = PublicationDocument::find($id);
            $this->dispatchBrowserEvent('delete-document');
        }
        else{
            $this->alert('error', "Houve um erro selecionar a Publicação!");
        }
    }
    public function destroy()
    {

        $path = Storage::delete('publication/'.$this->documetDestroy->path.$this->documetDestroy->slug.$this->documetDestroy->extension);
        if($path){

            $delete = $this->documetDestroy->delete();
            if($delete){
                $this->reset('documetDestroy');
                $this->alert('success', 'Publicação removida');
            }
            else{
                $this->alert('error', 'Houve um erro ao remover a publicação');
            }
        }
        else{
            $this->alert('error', 'Houve um erro ao remove a publicação');
        }

    }
    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'desc')->pluck('year','year');
        $this->types = PublicationType::where('status', 1)->where('publication_template_id', $this->publication->id)->pluck('type', 'id');
        $documentsPublication = PublicationDocument::where('publication_template_id', $this->publication->id)->paginate(10);
        return view('livewire.dashboard.publication.document', [
            'documentsPublication' => $documentsPublication,
            'years' =>  $years
        ]);
    }
}
