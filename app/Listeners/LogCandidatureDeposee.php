<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCandidatureDeposee
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
        $candidature =$event->candidature->load('profil.user','offre');
        $date=now()->toDateTimeString();
        $candidat=$candidature->profil->user->name;
        $offre=$candidature->offre->titre;
        $message="[{$date}] Candidature déposée - Candidat:{$candidat} | Offre: {$offre}\n";
        file_put_contents(storage_path('logs/candidature.log'),$message,FILE_APPEND);
    }
}
