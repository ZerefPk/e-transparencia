<?php

namespace App\Livewire\Dashboard\NormativeAct;

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
    public $singular;
    public $plural;
    public $parent_id;
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
            'singular' => 'required|min:2|max:255|unique:types_normatives_acts,singular,'.$id,
            'plural' => 'required|min:2|max:255|unique:types_normatives_acts,plural,'.$id,
            'type' => 'required',
            'parent_id' => 'required_if:type,1',
            'status' => 'required',
            'journaling' => 'required_if:type,0',
            'can_altered' => 'nullable',
            'can_revoked' => 'nullable',

        ];
    }
    protected $messages = [
        'parent_id.required_if' => "O campo [Raiz] é obrigatório quando [Tipo] for Subtipo",
        'journaling.required_if' => "O campo [Publicado em Diário] é obrigatório",
    ];
    protected $validationAttributes = [
        'singular' => '[Nome (Singular)]',
        'plural' => '[Nome (Plural)]',
        'type' => '[Tipo]',
        'parent_id' => '[Raiz]',
        'status' => '[Status]',
        'journaling' => '[Publicado em Diário]',
        'can_altered' => '[Pode Alterar]',
        'can_revoked' => '[Pode Revogar]',

    ];
    public function unSetAttr(Type $var = null)
    {
        $this->reset([
            'singular',
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
        //dd($this->singular);
        $data = $this->validate();
        //dd($data['can_altered']);
        $data['can_altered'] = ($data['can_altered']) ? implode('|',$data['can_altered']) : null;
        $data['can_revoked'] = ($data['can_revoked']) ? implode('|',$data['can_revoked']) : null;
        $data['journaling'] = (isset($data['journaling'])) ? $data['journaling'] : 1;
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
        $this->singular = $this->typeNomativeAct->singular;
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
        $types = TypeNormativeAct::where('status', true)->where('type', false)->get();



        return view('livewire.dashboard.normative-act.type', [
            'typesNomativeActs' => $typesNomativeActs,
            'types' => $types
        ]);
    }
}
