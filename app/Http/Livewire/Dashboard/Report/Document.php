<?php

namespace App\Http\Livewire\Dashboard\Report;

use App\Models\Report\ReportDocument;
use App\Models\Report\ReportTemplate;
use App\Models\Report\ReportType;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Document extends Component
{

    use WithFileUploads,WithPagination,LivewireAlert;

    public ReportTemplate $report;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['destroy' => 'destroy'];
    public $years;
    public $types;
    public $documetDestroy;
    public $year;
    public $publication_date;
    public $type_id;
    public $document;
    public $description;

    protected $rules = [
        'year' => 'required',
        'publication_date'  => 'required|date',
        'type_id'  => 'required',
        'document'  => 'required|file|mimes:pdf',
        'description'  => 'nullable|min:5|max:255',
    ];
    protected $validationAttributes = [
        'year' => '[ Ano ]',
        'publication_date' => '[ Publicação ]',
        'type_id' => '[ Categoria ]',
        'document' =>' [ Relatório [PDF] ]',
        'description' => '[ Descrição ]',
    ];
    public function mount($report)
    {
        $this->report = $report;
    }
    public function create()
    {
        $this->dispatchBrowserEvent('open-form-report');

    }
    public function store()
    {
        $data = $this->validate();
        $path = "{$this->report->title}/{$this->year}/";


        $save = ReportDocument::create([
            'path' => $path,
            'publication_date' => $this->publication_date,
            'description' => $this->description,
            'report_template_id' => $this->report->id,
            'report_type_id' => $this->type_id,
            'year' => $this->year,
        ]);

        if ($save) {
            $extension = $this->document->extension();
            $save->extension = '.'.$extension;
            $save->save();
            $path = $this->document->storeAs('report/'.$path, $save->slug.'.'.$extension, env('FILESYSTEM_DRIVER'));

            if ($path) {
                $this->dispatchBrowserEvent('close-form-report');
                $this->reset([ 'year','publication_date' ,'type_id','document', 'description']);
                $this->alert('success', 'Relatorio incluido com sucesso');
            }
            else{


                $this->alert('success', 'Houve um erro ao incluir relatório...');
                $save->delete();
            }

        }
    }
    public function delete($id)
    {
        $document = $this->report->documents->find($id);

        if($document)
        {
            $this->documetDestroy = ReportDocument::find($id);
            $this->dispatchBrowserEvent('delete-document');
        }
        else{
            $this->alert('error', "Houve um erro selecionar o relatório!");
        }
    }
    public function destroy()
    {

        $path = Storage::delete('report/'.$this->documetDestroy->path.$this->documetDestroy->slug.$this->documetDestroy->extension);
        if($path){

            $delete = $this->documetDestroy->delete();
            if($delete){
                $this->reset('documetDestroy');
                $this->alert('success', 'Relatório removido');
            }
            else{
                $this->alert('error', 'Houve um erro ao remover o relatório');
            }
        }
        else{
            $this->alert('error', 'Houve um erro ao remover o relatório');
        }

    }
    public function render()
    {
        $this->years = Year::where('status', 1)->orderBy('year', 'DESC')->pluck('year','year');
        $this->types = ReportType::where('status', 1)->where('report_template_id', $this->report->id)->pluck('type', 'id');
        $documentsReport = ReportDocument::where('report_template_id', $this->report->id)->paginate(10);
        return view('livewire.dashboard.report.document', [
            'documentsReport' => $documentsReport ,
        ]);
    }
}
