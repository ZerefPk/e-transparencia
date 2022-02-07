<?php

namespace App\Http\Livewire\Dashboard\NormativeAct;

use App\Models\NormativeAct\AlterNormativeAct;
use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Details extends Component
{
    use LivewireAlert;
    public NormativeAct $normativeAct;

    public TypeNormativeAct $types;

    public $altered_id;
    public $revoked_id;


    public function mount($id)
    {
        $this->normativeAct = NormativeAct::find($id);
        $this->types = TypeNormativeAct::find($this->normativeAct->type_id);
    }
    public function setAltered(){

        $data = $this->validate(
            ['altered_id' => 'required'],
            [
                'altered_id.required' => "Selecione o ATO",
            ]
        );

        $validate = AlterNormativeAct::where('parent_id', $this->normativeAct->id)->where('normative_act_id', $data['altered_id'])->first();

        if($validate)
        {
            $name = $validate->normativesActs->type->type.$validate->normativesActs->getRealNumber();
            $this->alert('error', 'A '.$name.' já foi alterar por esse ATO');
            return;
        }

        $save = AlterNormativeAct::create([
            'parent_id' => $this->normativeAct->id,
            'normative_act_id' => $data['altered_id'],
            'type' => 1,
        ]);

        if($save)
        {
            $normative = NormativeAct::find($data['altered_id']);
            $normative->altered = 1;
            $normative->save();
            $this->reset('altered_id');
            $this->alert('success', 'Incluida com sucesso');
        }
        else{
            $this->alert('error', 'Ocorreu um erro ao incluir');
        }
    }
    public function removeAltered($id)
    {
        $data = AlterNormativeAct::find($id);
        $normative_act_id = $data->normative_act_id;
        $data = $data->delete();
        if(!$data){
            $this->alert('error', 'Ocorreu um erro ao remover');
            return;
        }
        $consult = AlterNormativeAct::where('normative_act_id', $normative_act_id)->where('type',1)->where('parent_id','!=',$this->normativeAct->id)->get();
        if(count($consult) == 0)
        {
            $normative = NormativeAct::find($normative_act_id );
            $normative->altered = 0;
            $normative->save();
            $this->alert('success', 'Removida com sucesso');
        }
    }
    public function setRevoked(){

        $data = $this->validate(
            ['revoked_id' => 'required'],
            [
                'revoked_id.required' => "Selecione o ATO",
            ]
        );

        $validate = AlterNormativeAct::where('parent_id', $this->normativeAct->id)->where('normative_act_id', $data['revoked_id'])->first();
        $validateRevoker = AlterNormativeAct::where('normative_act_id', $data['revoked_id'])->where('type',)->first();
        if($validate)
        {
            $name = $validate->normativeAct->type->type.$validate->normativeAct->getRealNumber();
            $this->alert('error', 'A '.$name.' já foi alterar por esse ATO');
            return;
        }
        if($validateRevoker)
        {
            $name = $validate->normativeAct->type->type.$validate->normativeAct->getRealNumber();
            $this->alert('error', 'A '.$name.' já foi revogada');
            return;
        }

        $save = AlterNormativeAct::create([
            'parent_id' => $this->normativeAct->id,
            'normative_act_id' => $data['revoked_id'],
            'type' => 0,
        ]);

        if($save)
        {
            $normative = NormativeAct::find($data['revoked_id']);
            $normative->active = 0;
            $normative->revoked = 1;
            $normative->save();
            $this->resetPage('revoked_id');
            $this->alert('success', 'Incluida com sucesso');
        }
        else{
            $this->alert('error', 'Ocorreu um erro ao incluir');
        }
    }
    public function removeRevoked($id)
    {
        $data = AlterNormativeAct::find($id);
        $normative_act_id = $data->normative_act_id;
        $data = $data->delete();
        if(!$data){
            $this->alert('error', 'Ocorreu um erro ao remover');
            return;
        }
        $consult = AlterNormativeAct::where('normative_act_id', $normative_act_id)->where('type',0)->where('parent_id','!=',$this->normativeAct->id)->get();
        if(count($consult) == 0)
        {
            $normative = NormativeAct::find($normative_act_id );
            $normative->active = 1;
            $normative->revoked = 0;
            $normative->save();
            $this->alert('success', 'Removida com sucesso');
        }
    }
    public function render()
    {
        $canAltered =  $this->types->getCanAltered();
        $canRevoked = $this->types->getCanAltered();
        $listAltered = AlterNormativeAct::where('parent_id', $this->normativeAct->id)->where('type', 1)->get();
        $listRevoked = AlterNormativeAct::where('parent_id', $this->normativeAct->id)->where('type', 0)->get();
        //dd($listAltered);
        return view('livewire.dashboard.normative-act.details', [
            'canAltered' => $canAltered,
            'canRevoked' => $canRevoked,
            'listAltered' => $listAltered,
            'listRevoked' => $listRevoked,
        ]);
    }
}
