<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
Route::get('/autentic', [ApiController::class, 'autentic']);
Route::get('/create', [ApiController::class, 'create']);
Route::get('/store', [ApiController::class, 'store']);
Route::get('/show', [ApiController::class, 'show']);
Route::get('/edit', [ApiController::class, 'edit']);
Route::get('/update', [ApiController::class, 'update']);
Route::get('/destroy', [ApiController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
