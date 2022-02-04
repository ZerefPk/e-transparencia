<?php

namespace App\Http\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\TypeNormativeAct;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Type extends Component
{

    use LivewireAlert, WithPagination;

    public $typeNomativeAct;
    public $method;

    public $type;
    public $plural;
    public $status;
    public $journaling;
    public $can_altered;
    public $can_revoked;

    public $t;
    public $s;

    public $queryString = ['t','s'];

    public function rules() {
        $id = ($this->typeNomativeAct) ? $this->typeNomativeAct->id : 0;
        return [
            'type' => 'required|min:2|max:255|unique:types_normatives_acts,type,'.$id,
            'plural' => 'required|min:2|max:255|unique:types_normatives_acts,type,'.$id,
            'status' => 'required',
            'journaling' => 'required',
            'can_altered' => 'nullable',
            'can_revoked' => 'nullable',

        ];
    }
    protected $validationAttributes = [
        'type' => '[Tipo]',
        'plural' => '[Plural]',
        'status' => '[Status]',
        'journaling' => '[Publicado em Diário]',
        'can_altered' => '[Pode Alterar]',
        'can_revoked' => '[Pode Revogar]',

    ];
    public function unSetAttr(Type $var = null)
    {
        $this->reset([
            'type',
            'plural',
            'status',
            'can_altered',
            'can_revoked',
            'method',
            'typeNomativeAct',
        ]);
    }
    public function query()
    {
        $query = TypeNormativeAct::query();

        if(isset($this->t) && $this->t !="")
        {
            $query->where('type', 'like', $this->t.'%');
        }
        if(isset($this->s) && $this->s !=""){
            $query->where('status', $this->s.'%');
        }
        $query->orderBy('type', 'ASC');

        return $query;
    }
    public function refreshQuery()
    {
        $this->reset(['t','s']);
    }
    public function create(Type $var = null)
    {
        $this->unSetAttr();
        $this->method = 0;
        $this->dispatchBrowserEvent('open-form');

    }
    public function store()
    {
        $data = $this->validate();
        //dd($data['can_altered']);
        $data['can_altered'] = ($data['can_altered']) ? implode('|',$data['can_altered']) : null;
        $data['can_revoked'] = ($data['can_revoked']) ? implode('|',$data['can_revoked']) : null;
        $save = TypeNormativeAct::create($data);
        if ($save) {
            $this->unSetAttr();
            $this->dispatchBrowserEvent('close-form');
            $this->alert('success', 'Tipo de ato normativo criado com sucesso', [
                'toast' => false,
                'position' => 'center'
            ]);

        }
        else{

            $this->alert('success', 'Houve um erro ao criar o tipo ato normativo!');

        }
    }
    public function edit($id)
    {
        $this->unSetAttr();
        $this->method = 1;
        $this->typeNomativeAct = TypeNormativeAct::find($id);
        //dd($this->typeNomativeAct->isCanRevoked(1));
        $this->type = $this->typeNomativeAct->type;
        $this->plural = $this->typeNomativeAct->plural;
        $this->status = $this->typeNomativeAct->status;
        $this->journaling = $this->typeNomativeAct->journaling;
        $this->can_altered = ($this->typeNomativeAct->can_altered) ? explode('|',$this->typeNomativeAct->can_altered) : null;
        $this->can_revoked = ($this->typeNomativeAct->can_revoked) ? explode('|',$this->typeNomativeAct->can_revoked) : null;
        $this->dispatchBrowserEvent('open-form');
    }
    public function update()
    {
        $data = $this->validate();

        $data['can_altered'] = ($data['can_altered']) ? implode('|',$data['can_altered']) : null;
        $data['can_revoked'] = ($data['can_revoked']) ? implode('|',$data['can_revoked']) : null;
        $save = $this->typeNomativeAct->update($data);
        if ($save) {
            $this->unSetAttr();
            $this->dispatchBrowserEvent('close-form');
            $this->alert('success', 'Tipo de ato normativo atualizado com sucesso', [
                'toast' => false,
                'position' => 'center'
            ]);

        }
        else{

            $this->alert('success', 'Houve um erro ao atualizar o tipo ato normativo!');

        }
    }
    public function render()
    {
        $typesNomativeActs = $this->query()->paginate(10);
        $types = TypeNormativeAct::where('status', true)->get();
        return view('livewire.dashboard.normative-act.type', [
            'typesNomativeActs' => $typesNomativeActs,
            'types' => $types
        ]);
    }
}
