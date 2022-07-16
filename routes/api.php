<?php

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
Route::post('/login', 'UserController@login');
Route::get('/loginget', function(){
    return "login form";
});
Route::post('/register', 'UserController@register');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function(){
Route::post('/addrecipe','RecipeController@store');
Route::post('/updaterecipe','RecipeController@update');

Route::get('/recipebyingredient/{id}','RecipeController@RecipeByIngredient');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
