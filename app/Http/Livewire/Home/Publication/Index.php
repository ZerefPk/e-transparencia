<?php

namespace App\Http\Livewire\Home\Publication;

use App\Models\Publication\PublicationDocument;
use App\Models\Publication\PublicationTemplate;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public PublicationTemplate $publication;
    public $listSearch = array();
    public $a;
    public $t;
    public $i;
    public $f;

    public $queryString = [
        'a' =>  ['except' => ''],
        't' =>  ['except' => ''],
        'i' =>  ['except' => ''],
        'f'=>  ['except' => '']
    ];
    public function mount($publication)
    {
        $this->publication = $publication;
    }
    public function updatingA()
    {
        $this->gotoPage(1);
    }
    public function updatingT()
    {
        $this->gotoPage(1);
    }
    public function updatingI()
    {
        $this->gotoPage(1);
    }
    public function updatingF()
    {
        $this->gotoPage(1);
    }

    public function resetAttr()
    {
        $this->reset(['a', 't', 'i', 'f']);
        $this->listSearch = array();
    }
    public function query()
    {
        $initial = $this->publication->documents()->min('publication_date');
        $final = $this->publication->documents()->max('publication_date');

        $documents = PublicationDocument::query();
        $documents->where('Publication_template_id', $this->publication->id);
        if(isset($this->a) && $this->a != ""){
            $documents->where('year', $this->a);
            $this->listSearch['year'] = ['field' =>'Ano', 'value' => $this->a];
        }
        if(isset($this->t) && $this->t != ""){

            $type = $this->publication->publicationType->where('status', 1)->where('slug', $this->t)->first();

            $documents->where('publication_type_id', $type->id);
            $this->listSearch['title'] = ['field' =>'Titulo', 'value' => $type->type];

        }
        if(isset($this->i) && $this->i != ""){
            $initial = $this->i;
            $this->listSearch['initial'] = ['field' =>'Período de', 'value' => date('d/m/Y', strtotime( $this->i)) ];


        }
        if(isset($this->f) && $this->f != ""){
            $final = $this->f;
            $this->listSearch['final'] = ['field' =>'Período até', 'value' => date('d/m/Y', strtotime( $this->f)) ];
        }
        $documents->whereBetween('publication_date',[$initial, $final]);
        $documents->orderBy('publication_date', 'DESC');

        return $documents;
    }
    public function render()
    {
        $years = Year::where('status', 1)->orderBy('year', 'DESC')->get();
        $documents = $this->query()->paginate(10);
        return view('livewire.home.publication.index',[
            'years' => $years,
            'documents' => $documents,
        ])->layout('layouts.app');
    }
}
