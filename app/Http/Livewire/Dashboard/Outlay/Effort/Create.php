<?php

namespace App\Http\Livewire\Dashboard\Outlay\Effort;

use App\Models\Budget\BudgetAccount;
use App\Models\Budget\BudgetRamification;
use App\Models\Contract\Contract;
use App\Models\Outlay\Effort;
use App\Models\Provider\Provider;
use App\Models\Year;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $year;
    public $number;
    public $date_effort;
    public $type;
    public $reservation_number;
    public $description;
    public $number_installments;
    public $unitary_value;
    public $total_value;
    public $adjusted_value = 0;
    public $current_value;
    public $executed_installments;
    public $total_executed = 0;
    public $total_to_executed = 0;
    public $finished;
    public $status;
    public $complement;
    public $process_number;
    public $provider_id;
    public $contract_id;
    public $project_id;
    public $subproject_id;
    public $action_id;
    public $budget_account_id;
    public $modality_id;


    protected $rules = [
        'year' => 'required',
        'number' => 'required',
        'date_effort' => 'required',
        'type' => 'required',
        'reservation_number' => 'nullable',
        'description' => 'required',
        'number_installments' => 'required',
        'unitary_value' => 'required',
        'total_value' => 'required',
        'adjusted_value' => 'required',
        'current_value' => 'required',
        'executed_installments' => 'required',
        'total_executed' => 'required',
        'total_to_executed' => 'required',
        'finished' => 'required',
        'status' => 'required',
        'complement' => 'nullable',
        'process_number' => 'nullable',
        'provider_id' => 'required',
        'contract_id' => 'nullable',
        'project_id' => 'required',
        'subproject_id' => 'nullable',
        'action_id' => 'required',
        'budget_account_id' => 'required',
        'modality_id' => 'required',
    ];
    protected $validationAttributes = [
        'year' => '[Ano do empenho]',
        'number' => '[Número do empenho]',
        'date_effort' => '[Data do empenho]',
        'type' => '[Tipo do empenho]',
        'reservation_number' => '[Número da reserva]',
        'number_installments' => '[Número de parcelas]',
        'unitary_value' => '[Valor da parcela]',
        'total_value' => '[Valor do empenho]',
        'adjusted_value' => '[Ajustes]',
        'current_value' => '[Valor atual]',
        'executed_installments' => '[Parcelas executadas]',
        'total_executed' => '[Total executado]',
        'total_to_executed' => '[Total a executar]',
        'finished' => '[Finalizado]',
        'status' => '[Status]',
        'complement' => '[complemento]',
        'process_number' => '[Número do processo]',
        'provider_id' => '[Beneficiário]',
        'contract_id' => '[Contrato]',
        'project_id' => '[Projeto]',
        'subproject_id' => '[SubProjeto]',
        'action_id' => '[Ação]',
        'budget_account_id' => '[Conta]',
        'modality_id' => '[Modalidade]',
    ];
    public function store()
    {
        $data = $this->validate();
        $validate = Effort::where('year', $this->year)
            ->where('number', $this->number)->get();
        if (count($validate) > 0) {
            $this->alert('error', 'Empenho já cadastrado!');
        } else {
            $save = Effort::create($data);
            if ($save) {
                $this->flash('success', 'Empenho cadastrado!', [
                    'toast' => false,
                    'position' => 'center'
                ]);

                return redirect()->route('dashboard.effort.index');
            } else {
                $this->alert('error', 'Ocorreu um erro ao cadastar o Empenho...');
            }
        }
    }
    public function render()
    {

        $providers = Provider::where('status', true)->orderBy('slug', 'DESC')->get();
        $contracts = Contract::where('provider_id', $this->provider_id)->where('status', true)->orderBy('slug', 'DESC')->get();
        $years = Year::where('status', true)->orderBy('year', 'DESC')->pluck('year', 'year');
        $types = Effort::types();
        $projects = BudgetRamification::where('status', true)
            ->where('type', 1)
            ->orderBy('cod', 'ASC')
            ->get();
        $subProjects = BudgetRamification::where('status', true)
            ->where('type', 2)
            ->where('project_id', $this->project_id)
            ->orderBy('cod', 'ASC')
            ->get();
        $accounts = BudgetAccount::where('status', true)
            ->orderBy('ledger_account', 'ASC')
            ->get();
        $actions = BudgetRamification::where('status', true)
            ->where('type', 3)
            ->orderBy('cod', 'ASC')
            ->get();
        $modalities = BudgetRamification::where('status', true)
            ->where('type', 4)
            ->orderBy('cod', 'ASC')
            ->get();

        if (
            $this->total_value > 0 && $this->number_installments > 0
            && is_numeric($this->adjusted_value) && is_numeric($this->total_value)
            && is_numeric($this->number_installments)
        ) {
            if (is_numeric($this->number_installments)) {
                $this->unitary_value = round(($this->total_value + ($this->adjusted_value)) / $this->number_installments, 2);
            }

            $this->current_value = round($this->total_value + ($this->adjusted_value), 2);
            $this->total_to_executed = round($this->current_value - ($this->total_executed), 2);
        }



        return view('livewire.dashboard.outlay.effort.create', [
            'years' => $years,
            'providers' => $providers,
            'contracts' => $contracts,
            'types' => $types,
            'projects' => $projects,
            'subProjects' => $subProjects,
            'actions' => $actions,
            'accounts' => $accounts,
            'modalities' => $modalities,

        ]);
    }
}
