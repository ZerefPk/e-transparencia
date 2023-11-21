<?php

namespace App\Http\Livewire\Dashboard\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Bidding\BiddingAdditional;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Additional extends Component
{
    use LivewireAlert;
    protected $listeners = ['destroyAdditional' => 'destroyAdditional'];
    public Bidding $bidding;
    public $biddingAdditional;
    public $methodForm = 'create';
    public $notice_number;
    public $bid_opening_date;
    public $bid_opening_hour;
    public $bid_closing_date;
    public $bid_closing_hour;
    public $description;

    protected $rules = [
        'notice_number' => 'required',
        'bid_opening_date' => 'nullable|date',
        'bid_opening_hour' => 'nullable',
        'bid_closing_date' => 'nullable|date',
        'bid_closing_hour' => 'nullable',
        'description' => 'nullable|min:5|max:1500',
    ];
    public $validationAttributes = [
        'notice_number' => '[Número do edital]',
        'bid_opening_date' => '[Data de aertura das propostas]',
        'bid_opening_hour' => '[Hora de abertura das propostas]',
        'bid_closing_date' => '[Data de fechamento das propostas]',
        'bid_closing_hour' => '[Hora de abertura das propostas]',
        'description' => '[Descrição]',
    ];
    public function create()
    {
        $dataForm = $this->validate();
        $dataForm['bidding_id'] = $this->bidding->id;

        $this->biddingAdditional =  BiddingAdditional::create($dataForm);
        if($this->biddingAdditional){
            $this->dispatch('close-form-additonal');
            $this->alert('success','Informação do certame Adicionado com sucesso!');

            $this->setAttributes();

        }
        else{
            $this->dispatch('close-form-additonal');
            $this->reset([
                'notice_number',
                'bid_opening_date',
                'bid_opening_hour' ,
                'bid_closing_date',
                'bid_closing_hour',
                'description',
            ]);
            $this->alert('error','Erro ao adicionar informação do certame!');
        }


    }
    public function setAttributes()
    {

        $this->methodForm = 'update';
        $this->notice_number = $this->biddingAdditional->notice_number;
        $this->bid_opening_date = $this->biddingAdditional->bid_opening_date;
        $this->bid_opening_hour = $this->biddingAdditional->bid_opening_hour;
        $this->bid_closing_date = $this->biddingAdditional->bid_closing_date;
        $this->bid_closing_hour = $this->biddingAdditional->bid_closing_hour;
        $this->description = $this->biddingAdditional->description;
    }
    public function update()
    {
        $dataForm = $this->validate();
        $update = $this->biddingAdditional->update($dataForm);
        if($update){
           $this->alert('success','Informação do certame atualizada com sucesso!');
        }
        else{
            $this->setAttributes();
            $this->alert('error','Erro ao atualizar informação do certame!');
        }
        $this->dispatch('close-form-additonal');
    }
    public function deleteAdditional(){
        $this->dispatch('delete-additonal');
    }
    public function destroyAdditional()
    {
        $delete = $this->biddingAdditional->delete();
        if($delete){
            $this->reset( [
                'biddingAdditional',
                'notice_number',
                'bid_opening_date',
                'bid_opening_hour',
                'bid_closing_date',
                'bid_closing_hour',
                'description',
            ]);
            $this->methodForm= 'create';
            $this->alert('success', 'Informação do certame removida com sucesso');
        }
        else{
            $this->alert('error', 'Houve um erro ao remover a informação do certame');
        }

    }
    public function mount($bidding)
    {
        $this->bidding = $bidding;
        if($bidding->additional){
            $this->biddingAdditional = $bidding->additional;
            $this->setAttributes();
        }
    }
    public function render()
    {
        return view('livewire.dashboard.bidding.additional');
    }
}
