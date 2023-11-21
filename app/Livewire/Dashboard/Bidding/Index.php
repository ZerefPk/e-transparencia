<?php

namespace App\Livewire\Dashboard\Bidding;

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
    public $page = 1;
    public $queryString = ['number','modality','year','status'];

    public function updatingNumber()
    {
        $this->gotoPage(1);
    }
    public function updatingModality()
    {
        $this->gotoPage(1);
    }
    public function updatingYear()
    {
        $this->gotoPage(1);
    }
    public function updatingStatus()
    {
        $this->gotoPage(1);
    }

    public function find()
    {

        $biddings = Bidding::query();

        if (isset($this->number)) {

            $biddings->where('number', 'like', '%'.$this->number);
        }
        if (isset($this->modality)) {

            $category = Category::where('slug',  $this->modality)->first();
            if($category)
            {
                $biddings->where('modality_id', $category->id);
            }
        }
        if (isset($this->status) && $this->status != "") {

            $biddings->where('status', $this->status);
        }
        if (isset($this->year)) {

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
