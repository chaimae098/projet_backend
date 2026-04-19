<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}

