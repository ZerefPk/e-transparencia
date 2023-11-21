<?php

namespace App\Http\Livewire\Dashboard\Publication;

use App\Models\Publication\PublicationTemplate;
use App\Models\Publication\PublicationType;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public PublicationTemplate $publication;

    public $category;
    public $type;
    public $status;
    public $method;

    protected $rules = [
        'type' => 'required|min:1',
        'status' => 'required'
    ];
    protected $validationAttributes = [
        'type' => '[ Titulo ]',
        'status' => '[ Status ]'
    ];

    public function mount($publication)
    {
        $this->publication = $publication;
    }

    public function create()
    {
        $this->reset('type', 'method', 'status');
        $this->method=0;
        $this->dispatch('open-form-category');
    }
    public function store()
    {
       $data = $this->validate();
       $data['publication_template_id'] = $this->publication->id;

       $save = PublicationType::create($data);

       if($save){
        $this->reset(['type', 'method', 'status']);
        $this->dispatch('close-form-category');

        $this->alert('success', "Titulo criado com sucesso!");
       }
       else{
        $this->alert('error', 'Houve um erro ao criar titulo...');
       }

    }
    public function edit($id)
    {
        $this->reset(['type', 'method', 'status']);
        $this->category = PublicationType::findOrFail($id);
        $this->type = $this->category->type;
        $this->status = $this->category->status;
        $this->method=1;
        $this->dispatch('open-form-category');
    }
    public function update()
    {
       $data = $this->validate();

       $save = $this->category->update($data);

       if($save){
        $this->reset(['category','type', 'method', 'status','category']);
        $this->dispatch('close-form-category');

        $this->alert('success', "Titulo atualizado com sucesso!");
       }
       else{
        $this->alert('error', 'Houve um erro ao atualizar o titulo...');
       }

    }
    public function render()
    {
        $categories = PublicationType::where('publication_template_id', $this->publication->id)->paginate(10);
        return view('livewire.dashboard.publication.category', [
           'categories' => $categories,
        ]);
    }
}
