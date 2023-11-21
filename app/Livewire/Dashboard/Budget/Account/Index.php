<?php

namespace App\Livewire\Dashboard\Budget\Account;

use App\Models\Budget\BudgetAccount;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    public $account;
    public $method;

    public $reduced_account;
    public $ledger_account;
    public $description;
    public $status;

    public $r;
    public $l;
    public $d;
    public $s;

    public $queryString = ['r', 'l', 'd', 's'];

    public $rules = [
        'reduced_account' => 'nullable|min:2|max:255',
        'ledger_account' => 'required|min:2|max:255',
        'description' => 'required',
        'status' => 'required',
    ];
    public $validationAttributes = [
        'reduced_account' => '[Conta reduzida]',
        'ledger_account' => '[Conta Contábil]',
        'description' => '[Descrição]',
        'status' => '[Status]'
    ];
    public function updatingR()
    {
        $this->gotoPage(1);
    }
    public function updatingL()
    {
        $this->gotoPage(1);
    }
    public function updatingD()
    {
        $this->gotoPage(1);
    }
    public function updatingS()
    {
        $this->gotoPage(1);
    }
    public function query()
    {
        $query = BudgetAccount::query();

        if (isset($this->r) && $this->r == "") {
            $query->where('reduced_account', 'like',  $this->r . '%');
        }
        if (isset($this->l) && $this->l == "") {
            $query->where('ledger_account', 'like', $this->l . '%');
        }
        if (isset($this->d) && $this->d == "") {
            $query->where('description', 'like',  $this->d . '%');
        }

        if (isset($this->s) && $this->s == "") {
            $query->where('status',  $this->s);
        }

        $query->orderBy('ledger_account', 'ASC');

        return $query;
    }
    public function resetAttr()
    {
        $this->reset([
            'reduced_account',
            'ledger_account',
            'description',
            'status',
            'method',
            'account',
        ]);
    }
    public function refreshQuery()
    {
        $this->reset();
    }
    public function create()
    {
        $this->resetAttr();
        $this->method = 0;
        $this->dispatchBrowserEvent('open-form');
    }
    public function store()
    {
        $data = $this->validate();
        $unique = BudgetAccount::where('ledger_account', $data['ledger_account'])->first();

        if ($unique) {
            $this->alert('error', 'Conta Contábil já cadastrada...');
        } else {
            $unique = BudgetAccount::where('reduced_account', $data['reduced_account'])->first();
            $data['reduced_account'] = ($data['reduced_account'] == '') ? '000' : $data['reduced_account'];
            if ($unique && $unique->reduced_account =! '') {
                $this->alert('error', 'Conta Reduzida já cadastrada...');
            } else {
                $save = BudgetAccount::create($data);

                if ($save) {
                    if ($save) {

                        $this->alert('success', 'Conta cadastrada!', [
                            'toast' => false,
                            'position' => 'center'
                        ]);

                        $this->resetAttr();
                        $this->dispatchBrowserEvent('close-form');
                    } else {
                        $this->alert('error', 'Ocorreu um erro ao cadastar a Conta...');
                    }
                }
            }
        }
    }
    public function edit($id)
    {
        $this->resetAttr();
        $this->method = 1;
        $this->account = BudgetAccount::find($id);
        $this->reduced_account = $this->account->reduced_account;
        $this->ledger_account = $this->account->ledger_account;
        $this->description = $this->account->description;
        $this->status = $this->account->status;
        $this->dispatchBrowserEvent('open-form');
    }
    public function update()
    {
        $data = $this->validate();
        $unique = BudgetAccount::where('ledger_account', $data['ledger_account'])->first();

        if ($unique && $unique->id != $this->account->id) {
            $this->alert('error', 'Conta Contábil já cadastrada...');
        } else {
            $unique = BudgetAccount::where('reduced_account', $data['reduced_account'])->first();
            $data['reduced_account'] = ($data['reduced_account'] == '') ? '000' : $data['reduced_account'];
            if ($unique && $unique->reduced_account =! '' && $unique->id != $this->account->id) {
                $this->alert('error', 'Conta Reduzida já cadastrada...');
            } else {
                $save = $this->account->update($data);
                if ($save) {
                    if ($save) {

                        $this->alert('success', 'Conta atualizada!', [
                            'toast' => false,
                            'position' => 'center'
                        ]);

                        $this->resetAttr();
                        $this->dispatchBrowserEvent('close-form');
                    } else {
                        $this->alert('error', 'Ocorreu um erro ao atualizar a Conta...');
                    }
                }
            }
        }
    }
    public function render()
    {
        $accounts = $this->query()->paginate(10);
        return view('livewire.dashboard.budget.account.index', [
            'accounts' => $accounts,
        ]);
    }
}
