<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kanyeController;
use App\Http\Controllers\favouritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\ApiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/',function(){
    return redirect('/home');
});

Route::middleware('auth')->group(function () {
    Route::get('/home',[HomeController::class,'show']);
    Route::get('/favourites',[favouritesController::class,'show']);
    Route::get('/quotes',[kanyeController::class,'get_quote']);
    Route::post('/add-to-favourites',[favouritesController::class,'addToFavourites']);
    Route::get('/get-favorites-quotes',[favouritesController::class,'getFavoritesQuotes']);
    Route::delete('/delete-favourite-quote/{id}',[favouritesController::class,'deleteFavoriteQuote']);
    Route::get('/unAuthnticated',[ApiController::class,'unAuthnticated'])->name('unAuthnticated');
});

// delete the quote from favourites
