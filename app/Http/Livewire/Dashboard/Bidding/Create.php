<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Year;
use Livewire\Component;

class Create extends Component
{

    public $year;
    public $object;
    public $event_date;
    public $event_time;
    public $localization;
    public $number;
    public $contracted_value;
    public $estimated_value;
    public $budget_information;
    public $status;
    public $modality_id;
    public $type_id;
    public $situation_id;
    public $finality_id;

    protected $rules = [
            'number' => 'required',
            'object'=> 'required|min:10|max:1500',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'localization' => 'nullable',
            'estimated_value' => 'nullable',
            'contracted_value' => 'nullable',
            'budget_information' => 'nullable|min:5|max:1500',
            'status' => 'required',
            'year' => 'required',
            'modality_id' => 'required',
            'type_id' => 'required',
            'situation_id' => 'required',
            'finality_id' => 'required',
        ];


    public  $validationAttributes = [
            'number' => '[Número]',
            'object' => '[Objeto]',
            'event_date' => '[Data do certame]',
            'event_time' => '[Hora do certame]',
            'localization' => '[Localização]',
            'estimated_value' => '[Valor estimado]',
            'contracted_value' => '[Valor contratado]',
            'budget_information' => '[Informação orçamentaria]',
            'status' => '[Status]',
            'year' => '[Ano]',
            'modality_id' => '[Modalidade]',
            'type_id' => '[Tipo]',
            'situation_id' => '[Situação]',
            'finality_id' => '[Finalidade]',
        ];

    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year','year');
        $modalities = Category::where('type', 'bidding_modality')->pluck('category', 'id');
        $types = Category::where('type', 'bidding_type')->pluck('category', 'id');
        $situations = Category::where('type', 'bidding_situation')->pluck('category', 'id');
        $purposes = Category::where('type', 'bidding_finality')->pluck('category', 'id');
        return view('livewire.dashboard.bidding.create', [
            'years' => $years,
            'modalities' => $modalities ,
            'types' => $types,
            'situations' => $situations,
            'purposes'=> $purposes
        ]);
    }
    public function submit()
    {
        $data = $this->validate();
        $slugConsult = Bidding::where('slug', $this->year.'-'.$this->number)->get();

        if(count($slugConsult) > 0){
            flashNotification("Licitação já cadastrada!");

        }
        else
        {
            $save = Bidding::create($data);
            if ($save) {
                flashNotification("Licitação criada com sucesso!");
                return redirect()->route('dashboard.bidding.index');
            }

        }
        flashNotification("Erro ao criar Licitação!");
    }
}
