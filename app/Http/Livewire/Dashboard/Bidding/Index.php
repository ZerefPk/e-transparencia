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
        return redirect()->route('dashboard.bidding.index');
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
