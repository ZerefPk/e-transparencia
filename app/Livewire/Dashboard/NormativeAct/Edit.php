<?php

namespace App\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert, WithFileUploads;

    public NormativeAct $normativeAct;

    protected $listeners = ['unsetTypeAlter' => 'unsetTypeAlter'];
    public $year;
    public $type_id;
    public $number;
    public $description;
    public $ementa;
    public $active;
    public $publication_date;
    public $date_journal_publication;
    public $status;
    public $doc;
    public $pdf;

    public $journaling = 0;
    protected $rules = [

        'year' => 'required',
        'type_id' => 'required',
        'number' => 'required',
        'description' => 'required|min:2',
        'ementa' => 'required|min:2|max:1500',
        'active' => 'required',
        'publication_date' => 'required',
        'date_journal_publication' => 'nullable',
        'status' => 'required',
        'doc' => 'nullable|file|mimes:docx,doc',
        'pdf' => 'nullable|file|mimes:pdf',

    ];
    protected $validationAttributes = [

        'year' => '[Ano]',
        'type_id' => '[Tipo]',
        'number' => '[Numero]',
        'description' => '[Descrição]',
        'ementa' => '[Ementa]',
        'active' => '[Em vigor]',
        'publication_date' => '[Data da Publicação]',
        'date_journal_publication' => '[Data da Publicação em diário]',
        'status' => '[Status]',
        'doc' => '[DOCX, DOC]',
        'pdf' => '[PDF]',

    ];
    public function mount($id)
    {
        $this->normativeAct = NormativeAct::find($id);
        $this->year = $this->normativeAct->year;
        $this->type_id = $this->normativeAct->type_id;
        $this->number = $this->normativeAct->number;
        $this->description = $this->normativeAct->description;
        $this->ementa = $this->normativeAct->ementa;
        $this->publication_date = $this->normativeAct->publication_date;
        $this->date_journal_publication = $this->normativeAct->date_journal_publication;
        $this->active = $this->normativeAct->active;
        $this->status = $this->normativeAct->status;

    }

    public function unsetTypeAlter()
    {
        $this->type_id = $this->normativeAct->type_id;
    }
    public function update()
    {
        $data = $this->validate();

        $validate = NormativeAct::where('year', $this->year)
            ->where('number', $this->number)
            ->where('type_id', $this->type_id)
            ->where('id', '!=', $this->normativeAct->id )
            ->first();

        if($validate){

            $this->alert('error', 'Ato normativo já cadastrado...');
            return;

        }

        $type = TypeNormativeAct::find($this->type_id);
        $save = $this->normativeAct->update($data);

        $this->normativeAct->slug = "{$type->slug}-{$this->normativeAct->slug}";
        $this->normativeAct->save();

        if($save){

            $path = "{$this->year}/";
            if($data['doc']){
                $unset = Storage::delete('normativeact/'.$this->normativeAct->path_doc.$this->normativeAct->extencion_doc);
                $nameFile = "{$this->normativeAct->type->slug}-{$this->normativeAct->slug}";
                $extension = $this->doc->extension();
                $this->normativeAct->extencion_doc = '.'.$extension;

                $set = $this->doc->storeAs('normativeact/'.$path, $nameFile.'.'.$extension, env('FILESYSTEM_DRIVER'));
                $this->normativeAct->path_doc =  $path.$nameFile;
                $this->normativeAct->save();
            }
            if($data['pdf']){
                $data = Storage::delete('normativeact/'.$this->normativeAct->path_pdf.$this->normativeAct->extencion_pdf);
                $nameFile = "{$this->normativeAct->type->slug}-{$this->normativeAct->slug}";
                $extension = $this->pdf->extension();
                $this->normativeAct->extencion_pdf = '.'.$extension;
                $this->normativeAct->path_pdf =  $path.$nameFile;
                $this->normativeAct->save();
                $set = $this->pdf->storeAs('normativeact/'.$path, $nameFile.'.'.$extension, env('FILESYSTEM_DRIVER'));

            }
            $this->flash('success', 'Ato normativo cadastrado!', [
                'toast' => false,
                'position' => 'center'
            ]);

            return redirect()->route('dashboard.nomativesacts.details', $this->normativeAct->id);
        }
        else{
            $this->alert('error', 'Ocorreu um erro ao cadastar o Ato normativo...');
        }
    }
    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year','year');
        $types = TypeNormativeAct::where('status', true)->orderBy('type', 'DESC')->pluck('type', 'id');
        if(isset($this->type_id) && $this->type_id != ''){
            $typeNormativeAct = TypeNormativeAct::find($this->type_id);
            $this->journaling = $typeNormativeAct->journaling;
        }
        else{
            $this->journaling = 0;
        }
        if($this->normativeAct->type_id != $this->type_id){
            $this->dispatch('alter-type');
        }
        return view('livewire.dashboard.normative-act.edit', [
            'years' => $years,
            'types' => $types,
        ]);
    }

}
