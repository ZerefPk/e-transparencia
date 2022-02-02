<?php

namespace App\Http\Livewire\Home\Contract;

use App\Models\Category;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractAmendment;
use App\Models\Year;
use Livewire\Component;

class Statistic extends Component
{
    public function getRandomColor() {
        $letters = str_split('0123456789ABCDEF');
        $color = '#';
        for ($i = 0; $i < 6; $i++ ) {
            $color = "$color".$letters[mt_rand(0, 15)];
        }
        return $color;
    }
    public function perSubject()
    {
        $subjects = Category::where('type', 'contract_subject')->where('status', true)->where('in_grafic', true)->get();
        $labels= [];
        $datas = [];
        $colors = [];

        foreach ($subjects as $subject )
        {
            array_push($labels,$subject->category);
            array_push($colors,$subject->color);
            array_push($datas,Contract::where('subject_id', $subject->id)->where('status', true)
            ->count());

        }

        $perSubject = app()->chartjs
                            ->name('subject')
                            ->type('bar')
                            ->size(['width' => 50, 'height' => 15])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => "Assunto",
                            'backgroundColor' => $colors,
                            'data' => $datas,
                            ],
                        ])
                        ->options([
                            "indexAxis" => 'y',
                        ]);
        return $perSubject;
    }
    public function valuePerYear()
    {
        $years = Year::where('status', true)->get();
        $labels= [];
        $datas = [];


        foreach ($years as $year )
        {
            array_push($labels,$year->year);


            array_push($datas,Contract::where('year', $year->year)->where('status', true)
            ->sum('overall_contract_value'));

        }

        $valuePerYear = app()->chartjs
                            ->name('valuePerYear')
                            ->type('line')
                            ->size(['width' => 50, 'height' => 15])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => 'Valor Contratado R$: ',
                            'backgroundColor' => '#FFD700',
                            'data' => $datas,
                            ],
                        ])
                        ->options([

                        ]);
        return $valuePerYear;
    }
    public function valuePerContract()
    {
        $contracts = Contract::where('status', true)->get();
        $labels= [];
        $datas = [];
        $colors = [];

        foreach ($contracts as $contract )
        {
            array_push($labels,$contract->getRealNumber());
            array_push($colors,$this->getRandomColor());
            $total = ContractAmendment::where('type_modification', 0)->sum('total_value');

            $adds = ContractAmendment::where('type_modification', 1)->sum('total_value');
            $subs = ContractAmendment::where('type_modification', 2)->sum('total_value');

            $termination = ContractAmendment::where('type_modification', 3)->sum('total_value');


            $sum = ($total + $adds) - $subs - $termination ;
            array_push($datas, $sum);

        }

        $valuePerContract = app()->chartjs
                            ->name('valuePerContract')
                            ->type('bar')
                            ->size(['width' => 50, 'height' => 15])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => "Valor Total R$",
                            'backgroundColor' => $colors,
                            'data' => $datas,
                            ],
                        ])
                        ->options([
                            "indexAxis" => 'y',
                        ]);
        return $valuePerContract;
    }
    public function render()
    {
        $perSubject = $this->perSubject();
        $valuePerYear = $this->valuePerYear();
        $valuePerContract = $this->valuePerContract();
        return view('livewire.home.contract.statistic', [
            'perSubject' => $perSubject,
            'valuePerYear' => $valuePerYear,
            'valuePerContract' => $valuePerContract,
        ])->layout('layouts.app');
    }
}
