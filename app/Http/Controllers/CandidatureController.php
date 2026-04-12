<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;
use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;

class CandidatureController extends Controller
{
    // POST /api/offres/{offre}/candidater
    public function postuler(Request $request, Offre $offre)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'profil_id' => 'required|exists:profils,id',
        ]);

        $candidature = Candidature::create([
            'offre_id' => $offre->id,
            'profil_id' => $request->profil_id,
            'message' => $validated['message'],
            'statut' => 'en_attente'
        ]);
        event(new CandidatureDeposee($candidature));

        return response()->json($candidature, 201);
    }

    // PATCH /api/candidatures/{candidature}/statut
    public function changerStatut(Request $request, Candidature $candidature)
    {
        $request->validate(['statut' => 'required|in:en_attente,acceptee,refusee']);

        if (auth()->id() !== $candidature->offre->user_id) {
            return response()->json(['error' => 'Action non autorisée'], 403);
        }
        $ancienStatut = $candidature->statut;
        $candidature->update(['statut' => $request->statut]);
        event(new StatutCandidatureMis(
            $candidature,
            $ancienStatut,
            $request->statut
        ));
        return response()->json($candidature);
    }
}
