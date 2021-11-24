<?php

namespace App\Http\Livewire\Home\Bidding;

use App\Models\Bidding\Bidding;
use App\Models\Category;
use App\Models\Year;
use Livewire\Component;

class Statistic extends Component
{
    public Year $yearActive;

    public function mount($year){
        $this->yearActive = Year::find($year);
        if(!$this->yearActive){
            abort(404);
        }
    }
    public function quantityByYearModality(){

        $modalities = Category::where('type', 'bidding_modality')->where('status', true)->get();
        $biddings = Bidding::where('year', $this->yearActive->year)->where('status', true)->get();
        $labels = [];
        $colors = [];
        $datas = [];

        foreach ($modalities as $modality )
        {
            array_push($labels,$modality->category);
            array_push($colors,$modality->color);
            array_push($datas,$biddings->where('modality_id', $modality->id)
            ->count());

        }

        $modalitiesCharts = app()->chartjs
                            ->name('Modalidades')
                            ->type('pie')
                            ->size(['width' => 500, 'height' => 500])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => $this->yearActive->year,
                            'backgroundColor' => $colors,
                            'data' => $datas,
                            ],

                        ])
                        ->options([
                            "indexAxis" => 'y',
                        ]);

        return $modalitiesCharts;
    }
    public function valueByYearModality(){

        $modalities = Category::where('type', 'bidding_modality')->where('status', true)->get();
        $biddings = Bidding::where('year', $this->yearActive->year)->where('status', true)->get();
        $labels = [];
        $colors = [];
        $datas = [];

        foreach ($modalities as $modality )
        {
            array_push($labels,$modality->category);
            array_push($colors,$modality->color);
            array_push($datas,$biddings->where('modality_id', $modality->id)
            ->sum('contracted_value'));

        }

        $valuecontractedCharts = app()->chartjs
                            ->name('value_modality')
                            ->type('bar')
                            ->size(['width' => 200, 'height' => 76])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => 'R$'  ,
                            'backgroundColor' => $colors,
                            'data' => $datas,
                            ],

                        ])
                        ->options([

                        ]);

        return $valuecontractedCharts;
    }
    public function evolutionAB(String $a, String $b ){

        $a = Category::where('type', 'bidding_modality')
            ->where('status', true)->where('category', $a)->first();
        $b = Category::where('type', 'bidding_modality')
            ->where('status', true)->where('category', $b)->first();
        $years = Year::where('status', true)->get();


        $biddings = Bidding::where('status', true)->get();

        $labels = [];
        $datasA = [];
        $datasB = [];

        foreach($years as $year){
            array_push($labels, $year->year);

            array_push($datasA, $biddings->where('modality_id', $a->id)
                ->where('year', $year->year)
                ->count());
            array_push($datasB,$biddings->where('modality_id', $b->id)
                ->where('year', $year->year)
                ->count());
        }




        $evolutionAB = app()->chartjs
                            ->name('evolutionAB')
                            ->type('line')
                            ->size(['width' => 200, 'height' => 76])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => $a->category,
                            'backgroundColor' => $a->color,
                            'data' => $datasA,
                            ],
                             [
                            "label" => $b->category ,
                            'backgroundColor' => $b->color,
                            'data' => $datasB,
                            ],

                        ])
                        ->options([

                        ]);

        return $evolutionAB;
    }
    public function quantityByYearFinality(){

        $purposes = Category::where('type', 'bidding_finality')->where('status', true)->get();
        $biddings = Bidding::where('year', $this->yearActive->year)->where('status', true)->get();
        $labels = [];
        $colors = [];
        $datas = [];

        foreach ($purposes as $finality )
        {
            array_push($labels,$finality->category);
            array_push($colors,$finality->color);
            array_push($datas,$biddings->where('finality_id', $finality->id)
            ->where('status', true)
            ->count());

        }

        $quantityByYearFinality = app()->chartjs
                            ->name('quantityByYearFinality')
                            ->type('bar')
                            ->size(['width' => 200, 'height' => 76])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => 'Total'  ,
                            'backgroundColor' => $colors,
                            'data' => $datas,
                            ],

                        ])
                        ->options([
                            "indexAxis" => 'y',
                        ]);

        return $quantityByYearFinality;
    }

    public function valueByYearFinality(){

        $purposes = Category::where('type', 'bidding_finality')->where('in_grafic', true)->where('status', true)->get();
        $biddings = Bidding::where('year', $this->yearActive->year)->where('status', true)->get();
        $labels = [];
        $colors = [];
        $datas = [];

        foreach ($purposes as $finality )
        {
            array_push($labels,$finality->category);
            array_push($colors,$finality->color);
            array_push($datas,$biddings->where('finality_id', $finality->id)
            ->where('status', true)
            ->sum('contracted_value'));

        }

        $valueByYearFinality = app()->chartjs
                            ->name('valueByYearFinality')
                            ->type('bar')
                            ->size(['width' => 200, 'height' => 76])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => 'R$'  ,
                            'backgroundColor' => $colors,
                            'data' => $datas,
                            ],

                        ])
                        ->options([

                        ]);

        return $valueByYearFinality;
    }
    public function evolutionYear(){

        $years = Year::where('status', true)->get();


        $biddings = Bidding::where('status', true)->get();

        $labels = [];
        $datas = [];

        foreach($years as $year){
            array_push($labels, $year->year);
            array_push($datas,$year->biddings->where('status', true)->count());
        }


        $evolutionYear = app()->chartjs
                            ->name('evolutionYear')
                            ->type('line')
                            ->size(['width' => 400, 'height' => 200])
                        ->labels($labels)
                        ->datasets([
                            [
                            "label" => 'Total',
                            'backgroundColor' => 'green',
                            'data' => $datas,
                            ],


                        ])
                        ->options([

                        ]);

        return $evolutionYear;
    }
    public function render()
    {
        $years = Year::orderBy('year', 'DESC')->where('status', true)->limit(4)->get();


        $modalitiesYearCharts = $this->quantityByYearModality();

        $valuecontractedCharts = $this->valueByYearModality();

        $evolutionAB = $this->evolutionAB('Dispensa de Licitacao','Inexibilidade de Licitação');

        $quantityByYearFinality = $this->quantityByYearFinality();

        $valueByYearFinality = $this->valueByYearFinality();

        $evolutionYear = $this->evolutionYear();

        return view('livewire.home.bidding.statistic', [
            'years' => $years,
            'modalitiesYearCharts' => $modalitiesYearCharts,
            'valuecontractedCharts' => $valuecontractedCharts,
            'evolutionAB' => $evolutionAB,
            'quantityByYearFinality' => $quantityByYearFinality,
            'valueByYearFinality' => $valueByYearFinality,
            'evolutionYear' => $evolutionYear,
        ])->layout('layouts.app');
    }
}
