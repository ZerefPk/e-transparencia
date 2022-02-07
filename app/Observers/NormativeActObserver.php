<?php

namespace App\Observers;

use App\Models\NormativeAct\AlterNormativeAct;
use App\Models\NormativeAct\NormativeAct;
use App\Models\NormativeAct\TypeNormativeAct;

class NormativeActObserver
{
    /**
     * Handle the NormativeAct "created" event.
     *
     * @param  \App\Models\NormativeAct  $normativeAct
     * @return void
     */
    public function created(NormativeAct $normativeAct)
    {
        //
    }

    /**
     * Handle the NormativeAct "updated" event.
     *
     * @param  \App\Models\NormativeAct  $normativeAct
     * @return void
     */
    public function updated(NormativeAct $normativeAct)
    {
        //
        $type = TypeNormativeAct::where('id', $normativeAct->type_id)->first();

        foreach($normativeAct->alters as $alters){
            foreach ($type->getCanAltered() as $can){
                if($alters->id == $can->id){
                    $unset = 0;
                    break;
                }
                else{
                    $unset = 1;
                }
            }
            if($unset){
                $alterNormative = AlterNormativeAct::where('parent_id', $normativeAct)
                    ->where('normative_act_id', $alters->id)
                    ->where('type', 1)
                    ->first();
                $alters->altered = 0;
                $alters->save();
                $alterNormative->delete();
            }
        }
        foreach($normativeAct->revokes as $revoke)
        {
            foreach ($type->getCanRevoked() as $can){
                if($revoke->id == $can->id){
                    $unset = 0;
                    break;
                }
                else{
                    $unset = 1;
                }
            }
            if($unset){
                $revokedNormative = AlterNormativeAct::where('parent_id', $normativeAct)
                    ->where('normative_act_id', $alters->id)
                    ->where('type', 0)
                    ->first();
                $revoke->revoked = 0;
                $revoke->save();
                $revokedNormative->delete();
            }
        }

    }

    /**
     * Handle the NormativeAct "deleted" event.
     *
     * @param  \App\Models\NormativeAct  $normativeAct
     * @return void
     */
    public function deleted(NormativeAct $normativeAct)
    {
        //
    }

    /**
     * Handle the NormativeAct "restored" event.
     *
     * @param  \App\Models\NormativeAct  $normativeAct
     * @return void
     */
    public function restored(NormativeAct $normativeAct)
    {
        //
    }

    /**
     * Handle the NormativeAct "force deleted" event.
     *
     * @param  \App\Models\NormativeAct  $normativeAct
     * @return void
     */
    public function forceDeleted(NormativeAct $normativeAct)
    {
        //
    }
}
