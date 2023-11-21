<?php

namespace App\Livewire\Dashboard\Category;

use App\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $listeners = ['destroyCategory' => 'destroy'];
    public $queryString = ['type','status','q'];

    public $type;
    public $status;
    public $q;

    public $method;

    public $category;
    public $categoryInput;
    public $typeInput;
    public $statusInput;
    public $special_fieldInput;
    public $in_graficInput;
    public $colorInput;


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
    public function refresh()
    {
        $this->resetPage();
    }

    protected $rules = [
        'categoryInput' => 'required|min:2|max:255',
        'colorInput' => 'required',
        'in_graficInput' => 'required',
        'special_fieldInput' => 'nullable',
        'typeInput' => 'required',
        'statusInput'=> 'required',
    ];
    protected $validationAttributes = [
        'categoryInput' => '[ Categoria ]',
        'colorInput' => '[ Cor ]',
        'in_graficInput' => '[ Considerar em gráficos ]',
        'special_fieldInput' => '[ Campo especial ]',
        'typeInput' => '[ Tipo ]',
        'statusInput'=> '[ Status ]',
    ];
    public function resetPage()
    {
        $this->reset();
    }
    public function resetAttr()
    {
        $this->reset([
            'categoryInput',
            'colorInput',
            'in_graficInput' ,
            'special_fieldInput',
            'typeInput',
            'statusInput',
            'method',
            'category'
        ]);
    }
    public function create()
    {
        $this->resetAttr();
        $this->method = 0;
        $this->dispatch('open-form');
    }
    public function store()
    {
        $data = $this->validate();
        if (empty($data['special_fieldInput'])) {
            $data['special_fieldInput'] = 0;
        }
        $validation = Category::where('category', $this->categoryInput)
        ->where('type', $this->typeInput)->get();
        if (count($validation) > 0) {
            $this->alert('error', 'Categoria já cadastrada!');
        }
        else{
            $save = Category::create([
                'category' => $data['categoryInput'],
                'color'  => $data['colorInput'],
                'in_grafic' => $data['in_graficInput'],
                'special_field' => $data['special_fieldInput'],
                'type' => $data['typeInput'],
                'status' => $data['statusInput'],
            ]);

            if($save){
                $this->dispatch('close-form');
                $this->resetAttr();
                $this->alert('success', 'Categoria cadastrada!', [
                    'toast' => false,
                    'position' => 'center'
                ]);
            }
            else{
                $this->alert('error', 'Ocorreu um erro ao cadastar categoria...');
            }

        }

    }
    public function edit($id)
    {
        $this->resetAttr();

        $this->category = Category::find($id);

        $this->categoryInput = $this->category->category;
        $this->typeInput = $this->category->type;
        $this->statusInput = $this->category->status;
        $this->special_fieldInput = $this->category->special_field;
        $this->in_graficInput = $this->category->in_grafic;
        $this->colorInput = $this->category->color;
        $this->method = 1;
        $this->dispatch('open-form');
    }
    public function update()
    {
        $data = $this->validate();
        if (empty($data['special_fieldInput'])) {
            $data['special_fieldInput'] = 0;
        }

        $validation = Category::where('category', $this->categoryInput)
        ->where('type', $this->typeInput)->where('id', '!=', $this->category->id)->get();

        if (count($validation) > 0) {
            $this->alert('error', 'Categoria já cadastrada!');
        }
        else{
            $save = $this->category->update([
                'category' => $data['categoryInput'],
                'color'  => $data['colorInput'],
                'in_grafic' => $data['in_graficInput'],
                'special_field' => $data['special_fieldInput'],
                'type' => $data['typeInput'],
                'status' => $data['statusInput'],
            ]);

            if($save){
                $this->dispatch('close-form');
                $this->resetAttr();
                $this->alert('success', 'Categoria atualizada!', [
                    'toast' => false,
                    'position' => 'center'
                ]);
            }
            else{
                $this->alert('error', 'Ocorreu um erro ao atualizar categoria...');
            }

        }

    }

    public function render()
    {

        $paginate = $this->paginate();
        $types = Category::types();
        return view('livewire.dashboard.category.index',[
            'categories' =>  $paginate->paginate(10),
            'types' => $types,
        ]);
    }
}
