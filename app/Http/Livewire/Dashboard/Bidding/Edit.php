<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['destroy' => 'destroy'];

    public Bidding $bidding;
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

    public function mount($id) {
        $this->bidding = Bidding::find($id);

        if($this->bidding){
            $this->year = $this->bidding->year;
            $this->object = $this->bidding->object;
            $this->event_date = $this->bidding->event_date;
            $this->event_time = $this->bidding->event_time;
            $this->localization = $this->bidding->localization;
            $this->number = $this->bidding->number;
            $this->contracted_value = $this->bidding->contracted_value;
            $this->estimated_value = $this->bidding->estimated_value;
            $this->budget_information = $this->bidding->budget_information;
            $this->status = $this->bidding->status;
            $this->modality_id = $this->bidding->modality_id;
            $this->type_id = $this->bidding->type_id;
            $this->situation_id = $this->bidding->situation_id;
            $this->finality_id = $this->bidding->finality_id;
        }
        else{
            abort(404);
        }
    }
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
    public function delete(){
        $this->dispatchBrowserEvent('delete');
    }
    public function destroy(){
        $path = 'bidding/'.$this->bidding->year.'/'.$this->bidding->number;

        $path =( Storage::exists($path)) ? Storage::deleteDirectory($path) : true;
        if($path){
            $delete = $this->bidding->delete();
            if($delete){
                $this->flash('success', 'Licitação deletada!', [
                    'toast' => false,
                    'position' => 'center'
                ]);
                redirect()->route('dashboard.bidding.index');
            }
            else{
                $this->alert('error', 'Houve um erro ao deletar');
            }
        }
        else{
            $this->alert('error', 'Houve um erro ao deletar');
        }
    }

    public function submit()
    {
        $data = $this->validate();
        $data['object'] = strip_tags(html_entity_decode($data['object'], ENT_COMPAT, 'UTF-8'));
        $slugConsult = Bidding::where('slug', $this->year.'-'.$this->number)->first();

        if($slugConsult && $slugConsult->id != $this->bidding->id){


            $this->alert('error', 'Licitação já cadastrada!');
        }
        else{
            $save = $this->bidding->update($data);
            if ($save) {
                $this->alert('success', 'Licitação atualizada com sucesso!');
            }
            else{
                $this->alert('Error', 'Ocorreu um erro ao cadastar licitação...');

            }

        }

    }
    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year','year');
        $modalities = Category::where('type', 'bidding_modality')->pluck('category', 'id');
        $types = Category::where('type', 'bidding_type')->pluck('category', 'id');
        $situations = Category::where('type', 'bidding_situation')->pluck('category', 'id');
        $purposes = Category::where('type', 'bidding_finality')->pluck('category', 'id');
        return view('livewire.dashboard.bidding.edit', [
            'years' => $years,
            'modalities' => $modalities ,
            'types' => $types,
            'situations' => $situations,
            'purposes'=> $purposes
        ]);
    }
}
