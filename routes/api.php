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

Route::get("/listcategory",[CategorieController::class,"index"]);
Route::post("/addcategory",[CategorieController::class,"store"]);
Route::get("/all",[CategorieController::class,"allCategories"]);
Route::put("/updatecategory/{id}",[CategorieController::class,"update"]);
Route::delete("/supprimer",[CategorieController::class,"supprimer"]);
Route::get("/searchCategory",[CategorieController::class,"searchCategory"]);
Route::apiResource('fournisseurs', FournisseurController::class);
Route::apiResource('articles', ArticleController::class);
Route::get('/fournisseurs/search/{prenom}', [FournisseurController::class,'searchByFirstName']);
Route::delete('/articles/{id}', 'ArticleController@destroy');
Route::get('/articles/{id}', 'ArticleController@show');
Route::put('/articles/{id}', 'ArticleController@update');
Route::post('/vente-articles', [ArticleVenteController::class, 'store']);
Route::put('/vente-articles/{id}', [ArticleVenteController::class, 'update']);
Route::delete('/vente-articles/{id}', [ArticleVenteController::class, 'destroy']);
Route::get('/rechercher-article', [ArticleVenteController::class, 'search']);

