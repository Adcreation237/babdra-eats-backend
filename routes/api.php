<?php

use App\Http\Controllers\API\Admin\CategoriesController;
use App\Http\Controllers\API\Admin\CommandesController;
use App\Http\Controllers\API\Admin\FavourController;
use App\Http\Controllers\API\Admin\LivraisonController;
use App\Http\Controllers\API\Admin\PanierController;
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

    /*********************Admin statement ***********************/
    //Traitement de l'utilisateur Admin
    Route::get('admin/user/{user}', [UserController::class, 'showAdmin']);
    //Traitement Commandes Admin
    Route::get('admin/Mycommandes/{id}', [CommandesController::class, 'index']);
    Route::post('admin/Mycommandes/updatestatut/{id}/{statut}/{prix}', [CommandesController::class, 'edit']);
    //Traitement Livraison Admin
    Route::get('admin/MyLivraison/{id}', [LivraisonController::class, 'index']);
    //Traitement menus Admin
    Route::get('admin/Myplat/{id}', [PlatsController::class, 'index']);
    Route::post('admin/plat/store', [PlatsController::class, 'store']);
    Route::post('admin/plat/delete/{id}', [PlatsController::class, 'destroy']);
    Route::post('admin/plat/update/{id}', [PlatsController::class, 'edit']);
    //Traitement catégories Admin
    Route::get('admin/Allcategories', [CategoriesController::class, 'index']);

    /********************* Admin end statement *************************/


    /********************* Client statement ****************************/
    //Traitement catégories Admin
    Route::get('client/Allcategories', [CategoriesController::class, 'index']);
    //Traitement de l'utilisateur Client ok
    Route::get('client/user/{user}', [UserController::class, 'showUser']);
    //Traitement catégories client
    Route::get('client/somecategories', [CategoriesController::class, 'show']);
    Route::get('client/categories/{id}', [CategoriesController::class, 'showCat']);
    //Traitement menus Client
    Route::get('client/platpub/', [PlatsController::class, 'showPub']);
    Route::get('client/allplats/', [PlatsController::class, 'show']);
    Route::get('client/plat/{id}', [PlatsController::class, 'showPlat']);
    Route::get('client/searchplat/{colum}/{name}', [PlatsController::class, 'searchPlat']);
    //Traitement panier client
    Route::get('client/panier/{id}', [PanierController::class, 'index']);
    Route::post('client/panier/add', [PanierController::class, 'store']);
    Route::get('client/panier/delete/{id}', [PanierController::class, 'destroy']);

    //Traitement Commandes client
    Route::get('client/Mycommandes/{id}/{name}', [CommandesController::class, 'comClient']);
    Route::post('client/Mcommandes/add', [CommandesController::class, 'store']);

    //Traitement Favorites client
    Route::get('client/Favorite/{id}', [FavourController::class, 'index']);
    Route::post('client/Favorite/add', [FavourController::class, 'store']);
    Route::get('client/Favorite/delete/{id}', [FavourController::class, 'destroy']);

    /********************* Client end statement ****************************/

});
