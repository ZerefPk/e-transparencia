<?php

namespace App\Http\Livewire\Dashboard\Provider;

use App\Models\Provider\Provider;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;


    protected $paginationTheme = 'bootstrap';

    public $q;
    public $c;
    public $s;

    public $provider;

    public $method;
    public $queryString = ['q','c','s'];
    public $corporate_name;
    public $type;
    public $fantasy_name;
    public $cnpj;
    public $headquarters;
    public $first_digit;
    public $verify_digit;
    public $mei_company;
    public $status;
    public $legal_nature;

    protected function rules (){

        $id = (isset($this->provider)) ? $this->provider->id : 0;
        return [
            'corporate_name' => 'required|min:3|max:255',
            'fantasy_name' => 'nullable|min:1|max:255',
            'legal_nature' => 'nullable|min:3|max:255',
            'mei_company'=> 'required|boolean',
            'headquarters' => 'nullable|boolean',
            'status' => 'required|boolean',
            'type' => 'required|boolean',
            'cnpj' => 'exclude_if:type,0|unique:providers,cnpj,'.$id,
            'first_digit'=>'exclude_if:type,1|min:3|max:3',
            'verify_digit' => 'exclude_if:type,1|min:2|max:2',
        ];
    }
    protected $validationAttributes =  [
        'corporate_name' => '[ Razão Social ]',
        'fantasy_name' => '[ Nome Fantasia ]',
        'legal_nature' => '[ Natureza Jurídica ]',
        'mei_company'=> '[ Fornecedor MEI ]',
        'headquarters' => '[ Matriz ]',
        'status' => '[ Status ]',
        'type' => '[ Tipo [PF/PJ] ]',
        'cnpj' => '[ CNPJ ]',
        'first_digit'=>' [ Primeiros Digitos CPF ] ',
        'verify_digit' => '[ Digito verificador CPF ]',
    ];
    public function updatingQ()
    {
        $this->gotoPage(1);
    }
    public function updatingC()
    {
        $this->gotoPage(1);
    }
    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function query(){

        $query = Provider::query();

        if(isset($this->q) && $this->q !=""){
            $query->where('corporate_name', 'like', $this->q.'%');
        }
        if(isset($this->c) && $this->c !=""){
            $query->where('cpf', 'like', $this->c.'%')->orWhere('cnpj', 'like',$this->c.'%');
        }
        if(isset($this->s) && $this->s !=""){
            $query->where('status', $this->s.'%');
        }

        $query->orderBy('corporate_name', 'ASC');

        return $query;
    }
    public function refreshQuery()
    {
        $this->reset(['q','c','s']);
    }
    function updatingType(){
        if(!$this->type)
        {
            $this->dispatch('load-mask');
        }

    }
    public function create()
    {
        $this->method = 0;
        $this->reset(['corporate_name',
                    'fantasy_name',
                    'legal_nature',
                    'mei_company',
                    'headquarters',
                    'status',
                    'type',
                    'cnpj',
                    'first_digit',
                    'verify_digit',
        ]);
        $this->dispatch('open-form');
    }

    public function store()
    {
        $data = $this->validate();
        if(!$data['type']){
            $data['cpf'] = $data['first_digit'].".###.###-".$data['verify_digit'];
        }
        $save = Provider::create($data);

        if($save){
            $this->reset(['corporate_name',
                    'fantasy_name',
                    'legal_nature',
                    'mei_company',
                    'headquarters',
                    'status',
                    'type',
                    'cnpj',
                    'first_digit',
                    'verify_digit',
            ]);
            $this->dispatch('close-form');

            $this->alert('success', "Fornecedor criado com sucesso!", [
                'toast' => false,
                'position' => 'center'
            ]);
           }
        else{
            $this->alert('error', 'Houve um erro ao criar o Fornecedor...');
        }

    }

    public function edit($id)
    {
        $this->reset(['corporate_name',
                    'fantasy_name',
                    'legal_nature',
                    'mei_company',
                    'headquarters',
                    'status',
                    'type',
                    'cnpj',
                    'first_digit',
                    'verify_digit',
        ]);
        $this->provider = Provider::findOrFail($id);
        $this->corporate_name = $this->provider->corporate_name;
        $this->type = $this->provider->type;
        $this->fantasy_name = $this->provider->fantasy_name ;
        $this->cnpj = $this->provider->cnpj ;
        $this->headquarters = $this->provider->headquarters;

        $this->mei_company = $this->provider->mei_company;
        $this->status = $this->provider->status;
        $this->legal_nature = $this->provider->legal_nature;

        if(!$this->type){
            $temp = str_split($this->provider->cpf, 4);
            $this->first_digit = str_replace('.', '',$temp[0]);
            $this->verify_digit = $temp[3];
        }
        else{
            $this->dispatch('load-mask');
        }
        $this->method = 1;

        $this->dispatch('open-form');

    }
    public function update()
    {
        $data = $this->validate();
        if(!$data['type']){
            $data['cpf'] = $data['first_digit'].".###.###-".$data['verify_digit'];
            $data['headquarters'] = null;

        }

        if($this->provider->type != $data['type']){
            $this->provider->cpf = null;
            $this->provider->cnpj = null;
            $this->provider->headquarters = null;
            $this->provider->fantasy_name = null;
            $this->provider->save();

        }
        $save = $this->provider->update($data);

        if($save){
            $this->reset(['corporate_name',
                    'fantasy_name',
                    'legal_nature',
                    'mei_company',
                    'headquarters',
                    'status',
                    'type',
                    'cnpj',
                    'first_digit',
                    'verify_digit',
            ]);
            $this->dispatch('close-form');

            $this->alert('success', "Fornecedor atualizado com sucesso!", [
                'toast' => false,
                'position' => 'center'
            ]);
           }
        else{
            $this->alert('error', 'Houve um erro ao atualizar o Fornecedor...');
        }
    }
    public function render()
    {
        $providers = $this->query()->paginate(10);

        return view('livewire.dashboard.provider.index', [
            'providers' => $providers,
        ]);
    }


}
