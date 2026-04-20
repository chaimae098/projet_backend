<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    //
    public function store(Request $request){
        if($request->user()->profil){
            return response()->json(['message'=> 'Profil déjà existant'],422);
        }
        $data=$request->validate([
            'titre'=>'required|string',
            'bio'=>'nullable|string',
            'localisation'=>'nullable|string',
            'disponible'=>'boolean',
        ]);
        $profil =$request->user()->profil()->create($data);
        return response()->json($profil,201);
    }
    public function show(Request $request){
        return response()->json($request->user()->profil()->with('competences')->firstOrFail());
    }
    public function update(Request $request){
        $profil =$request->user()->profil;
        $data =$request->validate([
            'titre'=>'string',
            'bio'=>'nullable|string',
            'localisation'=>'nullable|string',
            'disponible'=>'boolean',

        ]);
        $profil->update($data);
        return response()->json($profil);
    }
    public function addCompetence(Request $request){
        $data =$request->validate([
            'competence_id'=>'required|exists:competences,id',
            'niveau'=>'required|in:débutant, intermédiaire,expert',
        ]);
        $profil =$request->user()->profil;
        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }
        $profil->competences()->syncWithoutDetaching([
            $data['competence_id'] => ['niveau' => $data['niveau']],
        ]);
        return response()->json(['message'=> 'Compétences ajoutées']);
    }
    public function removeCompetence(Request $request, $competence)
    {
        $profil = $request->user()->profil;

        if (!$profil) {
            return response()->json(['error' => 'Profil introuvable.'], 404);
        }

        $exists = $profil->competences()->where('competence_id', $competence)->exists();

        if (!$exists) {
            return response()->json(['error' => 'Cette compétence ne figure pas sur votre profil.'], 404);
        }

        $profil->competences()->detach($competence);

        return response()->json(['message' => 'Compétence retirée.']);
    }}
