<?php

namespace App\Http\Livewire\Dashboard\Contract;

use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Provider\Provider;
use App\Models\Year;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{
    use LivewireAlert;

    public Contract $contract;
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
        'signature_date' => '[Data da Assinatura]',
        'start__validity' => '[ Inicio da Vigência ]',
        'end_term'  => '[ Fim da Vigência ]',
        'contract_tax' => '[ Fiscal do Contrato ]',
        'contract_manager' => '[ Gestor do Contrato ]',
        'status' =>'[ Status ]',
        'year' =>  '[ Ano ]',
        'bidding_id' => '[ Histórico da Contratação]',
        'provider_id' => '[ Fornecedor ]',
    ];

    public function update(){
        $data = $this->validate();


        $slugConsult = Contract::where('slug', $this->year.'-'.$this->number)->where('id', '!=', $this->contract->id)->get();
        if(count($slugConsult) > 0){
            $this->alert('error', 'Contrato já cadastrado!');
        }
        else
        {
            $save = $this->contract->update($data);
            if ($save) {
                $this->flash('success', 'Contrato atualizado!', [
                    'toast' => false,
                    'position' => 'center'
                ]);

                return redirect()->route('dashboard.contract.index');
            }
            else{
                $this->alert('error', 'Ocorreu um erro ao atualizar o contrato...');

            }

        }
    }
    public function mount($contract)
    {
        $this->contract = $contract;
        $this->number = $this->contract->number;
        $this->object = $this->contract->object;
        $this->process_number = $this->contract->process_number;
        $this->form_contract_id = $this->contract->form_contract_id;
        $this->form_payment_id = $this->contract->form_payment_id;
        $this->overall_contract_value = $this->contract->overall_contract_value;
        $this->signature_date = $this->contract->signature_date;
        $this->start__validity = $this->contract->start__validity;
        $this->end_term = $this->contract->end_term;
        $this->contract_tax = $this->contract->contract_tax;
        $this->contract_manager = $this->contract->contract_manager;
        $this->status = $this->contract->status;
        $this->year = $this->contract->year;
        $this->bidding_id = $this->contract->bidding_id;
        $this->provider_id  = $this->contract->provider_id;
    }
    public function render()
    {
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year','year');
        $formContracts = Category::where('type', 'contract_form')->where('status', true)->orderBy('type', 'ASC')->pluck('category', 'id');
        $formPayments = Category::where('type', 'contract_payment')->where('status', true)->orderBy('type', 'ASC')->pluck('category', 'id');
        $providers = Provider::where('status', true)->orderBy('corporate_name', 'ASC')->get();
        $biddings = Bidding::where('status', true)->orderBy('year', 'DESC')->orderBy('number', 'ASC')->get();

        return view('livewire.dashboard.contract.edit', [
            'years' => $years,
            'formContracts' => $formContracts,
            'formPayments' => $formPayments,
            'providers' => $providers,
            'biddings' => $biddings,
        ]);
    }
}
