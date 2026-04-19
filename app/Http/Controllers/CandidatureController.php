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

        $profil = $request->user()->profil;
        if (!$profil || (int) $profil->id !== (int) $validated['profil_id']) {
            return response()->json(['error' => 'Profil invalide pour cet utilisateur'], 403);
        }

        $candidature = Candidature::create([
            'offre_id' => $offre->id,
            'profil_id' => $validated['profil_id'],
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

        if ((int) $request->user()->id !== (int) $candidature->offre->user_id) {
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

    // GET /api/offres/{offre}/candidatures
    public function indexParOffre(Request $request, Offre $offre)
    {
        if ((int) $request->user()->id !== (int) $offre->user_id) {
            return response()->json(['error' => 'Action non autorisee'], 403);
        }

        $candidatures = $offre->candidatures()
            ->with('profil.user:id,name,email')
            ->latest()
            ->get();

        return response()->json($candidatures);
    }

    // GET /api/mes-candidatures
    public function mesCandidatures(Request $request)
    {
        $profil = $request->user()->profil;
        if (!$profil) {
            return response()->json([], 200);
        }

        $candidatures = Candidature::query()
            ->where('profil_id', $profil->id)
            ->with('offre:id,user_id,titre,localisation,type,actif')
            ->latest()
            ->get();

        return response()->json($candidatures);
    }
}
