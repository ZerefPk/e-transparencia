<?php

namespace App\Providers;

use App\Models\Bidding\BiddingItem;
use App\Models\Contract\ContractAmendment;
use App\Observers\BiddingItemObserver;
use App\Observers\ContractAmendmentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        BiddingItem::observe(BiddingItemObserver::class);
        ContractAmendment::observe(ContractAmendmentObserver::class);
    }
}
