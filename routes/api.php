<?php

use App\Http\Controllers\BusinessSalesGuyController;
use App\Http\Controllers\PostalCodeController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/postal-code' , [PostalCodeController::class, 'store']);

Route::get('/getData', [BusinessSalesGuyController::class ,'fakeData']);
Route::get('/dataSelected', [BusinessSalesGuyController::class ,'dataSelected']);
