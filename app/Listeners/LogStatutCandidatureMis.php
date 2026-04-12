<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogStatutCandidatureMis
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        $date = now()->toDateTimeString();
        $ancien=$event->ancienStatut;
        $nouveau=$event->nouveauStatut;
        $message = "[{$date}] Statut modifié — Ancien: {$ancien} | Nouveau: {$nouveau}\n";
        file_put_contents(storage_path('logs/candidatures.log'), $message, FILE_APPEND);
    }
}
