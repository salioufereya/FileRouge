<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Models\Inscription;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('cours/getAllNeed', [CoursController::class, 'getAllNeed']);
Route::post('sessions/search', [SessionController::class, 'search']);
Route::post('sessions/annuler', [SessionController::class, 'annuler']);
Route::post('sessions/valider', [SessionController::class, 'valider']);
Route::post('sessions/terminer', [SessionController::class, 'terminer']);
Route::post('sessions/searchProf', [SessionController::class, 'searchProf']);
//Route::get('sessions/{prof}/sessions', [SessionController::class, 'getSessionsByProf']);
Route::get('professeurs/{prof}/session/{id}/demarrer', [ProfesseurController::class, 'demarrerSessionByProf']);

Route::post('professeurs/session/demandeAnnulation', [ProfesseurController::class, 'demandeAnnulation']);

Route::post('professeurs/cours', [ProfesseurController::class, 'getCoursByProf']);
Route::post('professeurs/sessions', [ProfesseurController::class, 'getSessionByProf']);
Route::apiResource('cours', CoursController::class);




Route::post('inscriptions/cours', [InscriptionController::class, 'coursByEleves']);
Route::post('inscriptions/sessions', [InscriptionController::class, 'sessionsByEleves']);
Route::apiResource('professeurs', ProfesseurController::class);
Route::post('inscriptions/{classe}/eleves', [InscriptionController::class, 'getElevesByClasse']);
Route::apiResource('inscriptions', InscriptionController::class);
Route::apiResource('modules', ModuleController::class);
Route::apiResource('semestres', SemestreController::class);
Route::apiResource('sessions', SessionController::class);

Route::post('login', [AuthController::class, 'login']);

Route::apiResource('users', UserController::class);
