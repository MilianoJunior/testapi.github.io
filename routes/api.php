<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes User
|--------------------------------------------------------------------------
*/

Route::post('/autentic', [UserController::class, 'autentic']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/getusers', [UserController::class, 'get_users']);
Route::post('/getuser', [UserController::class, 'get_user']);
Route::post('/createuser', [UserController::class, 'create_user']);
Route::post('/resetpassworduser', [UserController::class, 'reset_password_user']);
Route::post('/updateuser', [UserController::class, 'update_user']);
Route::post('/deleteuser', [UserController::class, 'delete_user']);

/*
|--------------------------------------------------------------------------
| API Routes Usina
|--------------------------------------------------------------------------
*/
// Route::get('/autentic', [ApiController::class, 'autentic']);
// Route::get('/getusers', [ApiController::class, 'get_users']);
// Route::post('/getuser', [ApiController::class, 'get_user']);
// Route::get('/createuser', [ApiController::class, 'create_user']);
// Route::get('/updateuser', [ApiController::class, 'update_user']);
// Route::get('/deleteuser', [ApiController::class, 'delete_user']);
/*
|--------------------------------------------------------------------------
| API Routes Usina
|--------------------------------------------------------------------------
*/
// Route::get('/create', [ApiController::class, 'create']);
// Route::get('/store', [ApiController::class, 'store']);
// Route::get('/show', [ApiController::class, 'show']);
// Route::get('/edit', [ApiController::class, 'edit']);
// Route::get('/update', [ApiController::class, 'update']);
// Route::get('/destroy', [ApiController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
