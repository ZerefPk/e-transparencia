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

    public function render()
    {

        $categories = Category::where('status', true)->where('type','like','bidding_%' )->get();
        $years = Year::where('status', true)->orderBy('year', 'DESC')->get();

        return view('livewire.dashboard.bidding.index', [
            'biddings' => Bidding::paginate(5),
            'years' => $years,
            'categories' => $categories,
        ]);
    }
}
