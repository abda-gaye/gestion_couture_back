<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleVenteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/vente-articles', [ArticleVenteController::class, 'store']);
Route::put('/vente-articles/{id}', [ArticleVenteController::class, 'update']);
Route::delete('/vente-articles/{id}', [ArticleVenteController::class, 'destroy']);
Route::get('/rechercher-article', [ArticleVenteController::class, 'search']);
Route::get('/vente-articles', [ArticleVenteController::class, 'index']);
