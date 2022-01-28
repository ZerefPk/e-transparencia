<?php

namespace App\Observers;

use App\Models\Contract\ContractAmendment;

class ContractAmendmentObserver
{
    /**
     * Handle the ContractAmendment "created" event.
     *
     * @param  \App\Models\ContractAmendment  $contractAmendment
     * @return void
     */
    public function created(ContractAmendment $contractAmendment)
    {
        //
    }

    /**
     * Handle the ContractAmendment "updated" event.
     *
     * @param  \App\Models\ContractAmendment  $contractAmendment
     * @return void
     */
    public function updated(ContractAmendment $contractAmendment)
    {
        //
    }

    /**
     * Handle the ContractAmendment "deleted" event.
     *
     * @param  \App\Models\ContractAmendment  $ContractAmendment
     * @return void
     */
    public function deleted(ContractAmendment $contractAmendment)
    {
        $amendments = ContractAmendment::where('contract_id', $contractAmendment->contract_id)
            ->orderBy('sequence')->where('type_modification', '!=' ,'0')->get();

        $cont = 2;
        if ($amendments) {
            foreach ($amendments as $item) {
                $item->sequence = $cont;

                $cont = $cont + 1;

                $item->save();
            }
        }

    }

    /**
     * Handle the ContractAmendment "restored" event.
     *
     * @param  \App\Models\ContractAmendment  $ContractAmendment
     * @return void
     */
    public function restored(ContractAmendment $ContractAmendment)
    {
        //
    }

    /**
     * Handle the ContractAmendment "force deleted" event.
     *
     * @param  \App\Models\ContractAmendment  $ContractAmendment
     * @return void
     */
    public function forceDeleted(ContractAmendment $ContractAmendment)
    {
        //
    }
}
