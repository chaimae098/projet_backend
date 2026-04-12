<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\ProfilController;

Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{offre}', [OffreController::class, 'show']);
Route::post('/offres', [OffreController::class, 'store']);
Route::put('/offres/{offre}', [OffreController::class, 'update']);
Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);

Route::post('/offres/{offre}/candidater', [CandidatureController::class, 'postuler']);
Route::get('/offres/{offre}/candidatures', [CandidatureController::class, 'indexParOffre']);
Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class, 'changerStatut']);
Route::get('/mes-candidatures', [CandidatureController::class, 'mesCandidatures']);

Route::post('/profil', [ProfilController::class, 'store']);
Route::get('/profil', [ProfilController::class, 'show']);
Route::put('/profil', [ProfilController::class, 'update']);
Route::post('/profil/competences', [ProfilController::class, 'addCompetence']);
Route::delete('/profil/competences/{competence}', [ProfilController::class, 'removeCompetence']);
