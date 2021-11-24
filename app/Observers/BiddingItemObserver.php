<?php

namespace App\Observers;

use App\Models\Bidding\BiddingItem;

class BiddingItemObserver
{
    /**
     * Handle the BiddingItem "created" event.
     *
     * @param  \App\Models\BiddingItem  $biddingItem
     * @return void
     */
    public function created(BiddingItem $biddingItem)
    {
        //
    }

    /**
     * Handle the BiddingItem "updated" event.
     *
     * @param  \App\Models\BiddingItem  $biddingItem
     * @return void
     */
    public function updated(BiddingItem $biddingItem)
    {
        //
    }

    /**
     * Handle the BiddingItem "deleted" event.
     *
     * @param  \App\Models\BiddingItem  $biddingItem
     * @return void
     */
    public function deleted(BiddingItem $biddingItem)
    {
        $biddingItens = BiddingItem::where('bidding_id', $biddingItem->bidding_id)
            ->orderBy('item')->where('bidding_item_group_id', null)->get();

        $cont = 1;
        if ($biddingItens) {
            foreach ($biddingItens as $item) {
                $item->item = $cont;

                $cont = $cont + 1;

                $item->save();
            }
        } else {
            $biddingItens = BiddingItem::where('bidding_id', $biddingItem->bidding_id)
                ->orderBy('item')->get();
            foreach ($biddingItens as $item) {
                $item->item = $cont;

                $cont = $cont + 1;

                $item->save();
            }
        }
    }

    /**
     * Handle the BiddingItem "restored" event.
     *
     * @param  \App\Models\BiddingItem  $biddingItem
     * @return void
     */
    public function restored(BiddingItem $biddingItem)
    {
        //
    }

    /**
     * Handle the BiddingItem "force deleted" event.
     *
     * @param  \App\Models\BiddingItem  $biddingItem
     * @return void
     */
    public function forceDeleted(BiddingItem $biddingItem)
    {
        //
    }
}
