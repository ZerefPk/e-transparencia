<?php

namespace App\Livewire\Home\NormativeAct;

use App\Models\NormativeAct\NormativeAct;
use Carbon\Carbon;
use Livewire\Component;

class Details extends Component
{
    public NormativeAct $normativeAct;
    public $mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );
    public function mount($normativeAct){

        $this->normativeAct = $normativeAct;


    }
    public function render()
    {

        return view('livewire.home.normative-act.details')->layout('layouts.app');
    }
}
