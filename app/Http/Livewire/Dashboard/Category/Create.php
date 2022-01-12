<?php

namespace App\Http\Livewire\Dashboard\Category;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public $category;
    public $type;
    public $status;
    public $special_field;
    public $in_grafic;
    public $color;

    protected $rules = [
        'category' => 'required|min:2|max:255',
        'color' => 'required',
        'in_grafic' => 'required',
        'special_field' => 'nullable',
        'type' => 'required',
        'status'=> 'required',
    ];
    protected $validationAttributes = [
        'category' => '[ Categoria ]',
        'color' => '[ Cor ]',
        'in_grafic' => '[ Considerar em gráficos ]',
        'special_field' => '[ Campo especial ]',
        'type' => '[ Tipo ]',
        'status'=> '[ Status ]',
    ];
    public function create()
    {
        $data = $this->validate();
        if (empty($dataForm['special_field'])) {
            $dataForm['special_field'] = 0;
        }

        $save = Category::create($data);
        dd($save);

    }
    public function render()
    {
        $types = Category::types();
        return view('livewire.dashboard.category.create', [
            'types' => $types
        ]);
    }
}
