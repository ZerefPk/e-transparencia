<?php

namespace App\Livewire\Dashboard\Publication;

use App\Models\Publication\PublicationTemplate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $publication;
    public $title;
    public $status;
    public $description;
    public $q;
    public $s;
    public $method;

    public $queryString = ['s','q'];

    public $rules = [
        'title' => 'required|min:3|max:18',
        'description' => 'nullable|min:5|max:2500',
        'status' => 'required',
    ];
    public $validationAttributes = [
        'title' => '[Titulo]',
        'description' => '[Descrição]',
        'status' => '[Status]',
    ];

    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function updatingQ()
    {
        $this->gotoPage(1);
    }
    public function refreshQuery()
    {
        $this->reset(['s','q']);
    }
    public function query()
    {
        $query = PublicationTemplate::query();
        if(isset($this->q) && $this->q != "");
        {
            $query->where('title', 'like', $this->q.'%');
        }
        if(isset($this->s) && $this->s != "")
        {
            $query->where('status', $this->s);
        }
        $query->orderBy('title', 'ASC');
        return $query;
    }

    public function create()
    {
       $this->reset(['title', 'status', 'description', 'method']);
       $this->method = 0;
       $this->dispatch('open-form');
    }
    public function store()
    {
        $data = $this->validate();

        $validate = PublicationTemplate::where('title', $this->title)->get();
        if(count($validate) > 0)
        {
            $this->alert('error', 'Publicação já cadastradA!');
        }
        else{
            $save = PublicationTemplate::create($data);
            if($save){
                $this->reset();
                $this->dispatch('close-form');
                $this->alert('success', 'Publicação Cadastrada', [
                    'toast' => false,
                    'position' =>  'center'
                ]);

            }
            else{
                $this->alert('error', 'Houve um erro ao cadastrar o Publicação...');
            }

        }

    }
    public function edit($id)
    {
        $this->reset(['title', 'status', 'description', 'method']);
        $this->publication = PublicationTemplate::findOrFail($id);
        $this->title = $this->publication->title;
        $this->status = $this->publication->status;
        $this->description = $this->publication->description;
        $this->method=1;
        $this->dispatch('open-form');
    }
    public function update()
    {
        $data = $this->validate();

        $validate = PublicationTemplate::where('title', $this->title)->where('id','!=', $this->publication->id)->get();
        if(count($validate) > 0)
        {
            $this->alert('error', 'Relatório já cadastrado!');
        }
        else{
            $save = $this->publication->update($data);
            if($save){
                $this->reset();
                $this->dispatch('close-form');
                $this->alert('success', 'Publicação atualizado', [
                    'toast' => false,
                    'position' =>  'center'
                ]);

            }
            else{
                $this->alert('error', 'Houve um erro ao atualizar o Publicação...');
            }

        }

    }
    public function render()
    {
        $templates = $this->query()->paginate(10);
        return view('livewire.dashboard.publication.index', [
            'templates' => $templates
        ]);
    }
}
