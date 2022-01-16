<?php

namespace App\Http\Livewire\Home\Report;

use App\Models\Report\ReportDocument;
use App\Models\Report\ReportTemplate;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\This;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public ReportTemplate $report;
    public $listSearch;
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
    public function mount($report)
    {
        $this->report = $report;
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
    }
    public function query()
    {
        $initial = $this->report->documents()->min('publication_date');
        $final = $this->report->documents()->max('publication_date');

        $documents = ReportDocument::query();
        $documents->where('report_template_id', $this->report->id);
        if(isset($this->a) && $this->a != ""){
            $documents->where('year', $this->a);
            $this->listSearch['year'] = ['field' =>'Ano', 'value' => $this->a];
        }
        if(isset($this->t) && $this->t != ""){

            $type = $this->report->reportType->where('status', 1)->where('slug', $this->t)->first();

            $documents->where('report_type_id', $type->id);
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
        return view('livewire.home.report.index',[
            'years' => $years,
            'documents' => $documents,
        ])->layout('layouts.app');
    }
}
