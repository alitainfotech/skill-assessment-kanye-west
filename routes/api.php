<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Middleware\ApiAuthntication;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[ApiController::class,'login']);

// Route::middleware('auth.api')->group( function () {
//     Route::get('/get-favorites',[ApiController::class,'getFavorites']);
//     Route::get('/generate-quotes/{count}',[ApiController::class,'generateQuotes']);
//     Route::get('/delete-quote',[ApiController::class,'deleteQuote']);
// });

Route::middleware('auth:api')->group(function () {
    Route::get('/get-favorites', [ApiController::class, 'getFavorites']);
    Route::get('/generate-quotes/{count}', [ApiController::class, 'generateQuotes']);
    Route::delete('/delete-quote/{id}', [ApiController::class, 'deleteQuote']);
    Route::get('/logout', [ApiController::class, 'logout']);
});
