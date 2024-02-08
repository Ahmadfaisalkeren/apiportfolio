<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HeroController;
use App\Http\Controllers\API\SkillsController;
use App\Http\Controllers\API\ContactsController;
use App\Http\Controllers\API\ProjectsController;
use App\Http\Controllers\API\CertificatesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('certificates', [CertificatesController::class, 'index']);
Route::post('certificate', [CertificatesController::class, 'store']);
Route::get('certificate/{id}/edit', [CertificatesController::class, 'edit']);
Route::put('certificate/{id}/update', [CertificatesController::class, 'update']);
Route::delete('certificate/{id}/delete', [CertificatesController::class, 'destroy']);

Route::get('contacts', [ContactsController::class, 'index']);
Route::post('contact', [ContactsController::class, 'store']);
Route::get('contact/{id}/edit', [ContactsController::class, 'edit']);
Route::put('contact/{id}/update', [ContactsController::class, 'update']);
Route::delete('contact/{id}/delete', [ContactsController::class, 'destroy']);

Route::get('heroes', [HeroController::class, 'index']);
Route::post('hero', [HeroController::class, 'store']);
Route::get('hero/{id}/edit', [HeroController::class, 'edit']);
Route::put('hero/{id}/update', [HeroController::class, 'update']);
Route::delete('hero/{id}/delete', [HeroController::class, 'destroy']);

Route::get('projects', [ProjectsController::class, 'index']);
Route::post('project', [ProjectsController::class, 'store']);
Route::get('project/{id}/edit', [ProjectsController::class, 'edit']);
Route::put('project/{id}/update', [ProjectsController::class, 'update']);
Route::delete('project/{id}/delete', [ProjectsController::class, 'destroy']);

Route::get('skills', [SkillsController::class, 'index']);
Route::post('skill', [SkillsController::class, 'store']);
Route::get('skill/{id}/edit', [SkillsController::class, 'edit']);
Route::put('skill/{id}/update', [SkillsController::class, 'update']);
Route::delete('skill/{id}/delete', [SkillsController::class, 'destroy']);
