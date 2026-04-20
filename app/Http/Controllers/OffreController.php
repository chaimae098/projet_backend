<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    // GET /api/offres
    public function index(Request $request)
    {
        $query = Offre::query()->where('actif', true);

        if ($request->filled('localisation')) {
            $query->where('localisation', 'like', '%' . $request->localisation . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $offres = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($offres);
    }

    // POST /api/offres
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'localisation' => 'required|string',
            'type' => 'required|in:CDI,CDD,stage',
        ]);

        $userId = auth()->id();

        if (!$userId) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }

        $offre = Offre::create(array_merge($validated, [
            'user_id' => $userId,
            'actif' => true
        ]));

        return response()->json($offre, 201);
    }

    public function show(Offre $offre)
    {
        return response()->json($offre);
    }

    public function update(Request $request, Offre $offre)
    {
        if (auth()->id() !== $offre->user_id) {
            return response()->json(['error' => 'Action interdite : vous n\'êtes pas le propriétaire.'], 403);
        }
        $validated = $request->validate([
            'titre'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'localisation'=> 'sometimes|string|max:255',
            'type'        => 'sometimes|in:CDI,CDD,stage',
            'actif'       => 'sometimes|boolean',
        ]);

        $offre->update($validated);

        return response()->json($offre);
    }

    public function destroy(Offre $offre)
    {
        if (auth()->id() !== $offre->user_id) {
            return response()->json(['error' => 'Action interdite.'], 403);
        }

        $offre->delete();
        return response()->json(['message' => 'Offre supprimée avec succès.']);
    }
}
