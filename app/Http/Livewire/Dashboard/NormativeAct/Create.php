<?php

namespace App\Http\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use App\Models\Year;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $year;
    public $type_id;
    public $number;
    public $description;
    public $ementa;
    public $publication_date;
    public $status;

    protected $rules = [

        'year' => 'required',
        'type_id' => 'required',
        'number' => 'required',
        'description' => 'required|min:2|max:255',
        'ementa' => 'required|min:2|max:1500',
        'publication_date' => 'required',
        'status' => 'required',

    ];
    protected $validationAttributes = [

        'year' => '[Ano]',
        'type_id' => '[Tipo]',
        'number' => '[Numero]',
        'description' => '[Descrição]',
        'ementa' => '[Ementa]',
        'publication_date' => '[Data da Publicação]',
        'status' => '[Status]',

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
        if($save){

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
        return view('livewire.dashboard.normative-act.create', [
            'years' => $years,
            'types' => $types,
        ]);
    }
}
