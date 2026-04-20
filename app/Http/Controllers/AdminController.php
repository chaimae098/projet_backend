<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Offre;
class AdminController extends Controller
{
    public function users(Request $request)
    {
        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->latest()
            ->paginate(20);

        return response()->json($users);
    }
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Vous ne pouvez pas supprimer votre propre compte.'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès.']);
    }

    public function toggleOffre(Offre $offre)
    {
        $offre->update(['actif' => !$offre->actif]);

        return response()->json([
            'message' => $offre->actif ? 'Offre activée.' : 'Offre désactivée.',
            'offre' => $offre
        ]);
    }
}

