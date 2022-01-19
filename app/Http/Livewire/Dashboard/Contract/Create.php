<?php

namespace App\Http\Livewire\Dashboard\Contract;

use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Provider\Provider;
use App\Models\Year;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $number;
    public $object;
    public $process_number;
    public $form_contract_id;
    public $form_payment_id;
    public $overall_contract_value;
    public $signature_date;
    public $start__validity;
    public $end_term;
    public $contract_tax;
    public $contract_manager;
    public $status;
    public $year;
    public $bidding_id;
    public $provider_id;


    public $rules = [
        'number' => 'required',
        'object' => 'required|min:5',
        'process_number' => 'required',
        'form_contract_id' => 'nullable',
        'form_payment_id' => 'required',
        'overall_contract_value' => 'required',
        'signature_date' => 'required|date',
        'start__validity' => 'required|date',
        'end_term'  => 'required|date',
        'contract_tax' => 'nullable|min:5|max:55',
        'contract_manager' => 'nullable|min:5|max:55',
        'status' =>'required|boolean',
        'year' =>  'required',
        'bidding_id' => 'nullable',
        'provider_id' => 'required',
    ];
    public $validationAttributes = [
        'number' => '[ Número ]',
        'object' => '[ Objeto ]',
        'process_number' => '[ Número do Processo ]',
        'form_contract_id' => '[ Tipo de Contratação ]',
        'form_payment_id' => '[ Forma de Pagamento ]',
        'overall_contract_value' => '[ Valor Total do Contrato ]',
        'signature_date' => '[Data da Assintura]',
        'start__validity' => '[ Inicio da Vigência ]',
        'end_term'  => '[ Fim da Vigência ]',
        'contract_tax' => '[ Fiscal do Contrato ]',
        'contract_manager' => '[ Gestor do Contrato ]',
        'status' =>'[ Status ]',
        'year' =>  '[ Ano ]',
        'bidding_id' => '[ Histórico da Contratação]',
        'provider_id' => '[ Fornecedor ]',
    ];

    public function store(){
        $data = $this->validate();


        $slugConsult = Contract::where('slug', $this->year.'-'.$this->number)->get();
        if(count($slugConsult) > 0){
            $this->alert('error', 'Contrato já cadastrado!');
        }
        else
        {
            $save = Contract::create($data);
            if ($save) {
                $this->flash('success', 'Contrato cadastrado!', [
                    'toast' => false,
                    'position' => 'center'
                ]);

                return redirect()->route('dashboard.contract.index');
            }
            else{
                $this->alert('error', 'Ocorreu um erro ao cadastar o contrato...');

            }

        }
    }
    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year','year');
        $formContracts = Category::where('type', 'contract_form')->where('status', true)->orderBy('type', 'ASC')->pluck('category', 'id');
        $formPayments = Category::where('type', 'contract_payment')->where('status', true)->orderBy('type', 'ASC')->pluck('category', 'id');
        $providers = Provider::where('status', true)->orderBy('corporate_name', 'ASC')->get();
        $biddings = Bidding::where('status', true)->orderBy('year', 'DESC')->orderBy('number', 'ASC')->get();

        return view('livewire.dashboard.contract.create', [
            'years' => $years,
            'formContracts' => $formContracts,
            'formPayments' => $formPayments,
            'providers' => $providers,
            'biddings' => $biddings,
        ]);
    }
}
