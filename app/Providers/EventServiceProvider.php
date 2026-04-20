<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CandidatureDeposee;
use App\Listeners\LogCandidatureDeposee;
use App\Events\StatutCandidatureMis;
use App\Listeners\LogStatutCandidatureMis;
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\CandidatureDeposee::class => [
            \App\Listeners\LogCandidatureDeposee::class,
        ],
        StatutCandidatureMis::class => [
            LogStatutCandidatureMis::class,
        ],
    ];
}
