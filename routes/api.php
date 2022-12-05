<?php

use App\Http\Controllers\API\Admin\CategoriesController;
use App\Http\Controllers\API\Admin\CommandesController;
use App\Http\Controllers\API\Admin\LivraisonController;
use App\Http\Controllers\API\Admin\PlatsController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\uploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(AuthController::class)->group(function(){
    //admin
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    //client
    Route::post('/signin', 'signin');
    Route::post('/auth', 'auth');
});

Route::post('categories/store', [CategoriesController::class, 'store']);

Route::middleware('auth:sanctum')->group( function () {

    //Traitement de l'utilisateur Admin
    Route::get('admin/user/{user}', [UserController::class, 'showAdmin']);
    //Traitement de l'utilisateur Admin
    Route::get('client/user/{user}', [UserController::class, 'showUser']);


    //Traitement catégories Admin
    Route::get('admin/Allcategories', [CategoriesController::class, 'index']);


    //Traitement catégories Admin
    Route::get('admin/Myplat/{id}', [PlatsController::class, 'index']);
    Route::post('admin/plat/store', [PlatsController::class, 'store']);
    Route::post('admin/plat/delete/{id}', [PlatsController::class, 'destroy']);
    Route::post('admin/plat/update/{id}', [PlatsController::class, 'edit']);

    //Traitement Commandes Admin
    Route::get('admin/Mycommandes/{id}', [CommandesController::class, 'index']);
    Route::post('admin/Mycommandes/updatestatut/{id}/{statut}/{prix}', [CommandesController::class, 'edit']);


    //Traitement Livraison Admin
    Route::get('admin/MyLivraison/{id}', [LivraisonController::class, 'index']);

});
