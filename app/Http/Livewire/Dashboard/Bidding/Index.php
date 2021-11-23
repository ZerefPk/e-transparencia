<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use Livewire\Component;
use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Year;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $number = null;
    public $modality = null;
    public $status = null;
    public $year = null;

    public $queryString = ['number','modality','year','status'];


    public function find()
    {

        $biddings = Bidding::query();

        if (isset($this->number)) {
            $this->goToPage(1);
            $biddings->where('number', 'like', '%'.$this->number);
        }
        if (isset($this->modality)) {
            $this->goToPage(1);
            $category = Category::where('slug',  $this->modality)->first();
            if($category)
            {
                $biddings->where('modality_id', $category->id);
            }
        }
        if (isset($this->status) && $this->status != "") {
            $this->goToPage(1);
            $biddings->where('status', $this->status);
        }
        if (isset($this->year)) {
            $this->goToPage(1);
            $biddings->where('year', $this->year);
        }

        $biddings = $biddings->orderBy('year', 'DESC')->orderBy('number', 'ASC');

        return $biddings;

    }
    public function resetPage()
    {
        $this->reset(['number','modality','year','status']);

    }
    public function render()
    {
        $categories = Category::where('status', true)->where('type','like','bidding_%' )->get();
        $years = Year::where('status', true)->orderBy('year', 'DESC')->get();
        $search = $this->find();
        return view('livewire.dashboard.bidding.index', [
            'biddings' => $search->paginate(10),
            'years' => $years,
            'categories' => $categories,
        ]);
    }

}
