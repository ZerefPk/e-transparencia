<?php

namespace App\Http\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use App\Models\Year;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads,LivewireAlert;

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
        'description' => 'required|min:2|max:255',
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

    public function store()
    {
        $data = $this->validate();
        $validate = NormativeAct::where('year', $this->year)->where('number', $this->number)->where('type_id', $this->type_id)->first();
        if($validate){
            $this->alert('error', 'Ato normativo já cadastrado...');
            return;
        }
        $type = TypeNormativeAct::find($this->type_id);
        $save = NormativeAct::create($data);
        $save->slug = "{$type->slug}-{$save->slug}";
        $save->save();

        if($save){
            $path = "{$this->year}/";
            if($data['doc']){
                $nameFile = "{$save->type->slug}-{$save->slug}";
                $extension = $this->doc->extension();
                $save->extencion_doc = '.'.$extension;

                $set = $this->doc->storeAs('normativeact/'.$path, $nameFile.'.'.$extension, env('FILESYSTEM_DRIVER'));
                $save->path_doc =  $path.$nameFile;
                $save->save();
            }
            if($data['pdf']){
                $nameFile = "{$save->type->slug}-{$save->slug}";
                $extension = $this->pdf->extension();
                $save->extencion_pdf = '.'.$extension;
                $save->path_pdf =  $path.$nameFile;
                $save->save();
                $set = $this->pdf->storeAs('normativeact/'.$path, $nameFile.'.'.$extension, env('FILESYSTEM_DRIVER'));

            }
            $this->flash('success', 'Ato normativo cadastrado!', [
                'toast' => false,
                'position' => 'center'
            ]);

            return redirect()->route('dashboard.nomativesacts.details', $save->id);
        }
        else{
            $this->alert('error', 'Ocorreu um erro ao cadastar o Ato normativo...');
        }
    }
    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year','year');
        $types = TypeNormativeAct::where('status', true)->orderBy('type', 'DESC')->pluck('type', 'id');
        if(isset($this->type_id)){
            $typeNormativeAct = TypeNormativeAct::find($this->type_id);
            $this->journaling = $typeNormativeAct->journaling;
        }
        return view('livewire.dashboard.normative-act.create', [
            'years' => $years,
            'types' => $types,
        ]);
    }
}
