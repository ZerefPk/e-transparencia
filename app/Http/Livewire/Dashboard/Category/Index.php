<?php

namespace App\Http\Livewire\Dashboard\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $type;
    public $status;
    public $q;

    public function updatingType()
    {
        $this->gotoPage(1);
    }
    public function updatingStatus()
    {
        $this->gotoPage(1);
    }
    public function updatingQ()
    {
        $this->gotoPage(1);
    }
    public function paginate(){
        $categories = Category::query();

        if (isset($this->status) && $this->status != "") {
            $categories->where('status', $this->status);
        }
        if (isset($this->q) && $this->q != "") {
            $categories->where('category', 'like', $this->q . '%');
        }
        if (isset($this->type) && $this->type != "") {
            $categories->where('type', $this->type);
        }
        $categories->orderBy('category','ASC');
        return $categories;
    }
    public function render()
    {
        return view('livewire.dashboard.category.index');
    }
}
