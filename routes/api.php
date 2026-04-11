<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;

Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{offre}', [OffreController::class, 'show']);
Route::post('/offres', [OffreController::class, 'store']);
Route::put('/offres/{offre}', [OffreController::class, 'update']);
Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);

Route::post('/offres/{offre}/candidater', [CandidatureController::class, 'postuler']);
Route::get('/offres/{offre}/candidatures', [CandidatureController::class, 'indexParOffre']);
Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class, 'changerStatut']);