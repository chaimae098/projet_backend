<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // List all users
    public function listUsers()
    {
        return response()->json(User::all());
    }

    // Delete a user
    public function deleteUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    // Toggle offer active status
    public function toggleOffre(Offre $offre)
    {
        $offre->update(['actif' => !$offre->actif]);
        return response()->json($offre);
    }
}
