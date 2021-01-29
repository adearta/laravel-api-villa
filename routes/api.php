<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/barang', PostControllerBarang::class);
Route::resource('/list-villa', PostControllerListVilla::class);
Route::resource('/pegawai', PostControllerPegawai::class);

// Route::post('/upload', [ImageController::class, 'upload']);
// Route::get('/getImageBarang', [PostControllerBarang::class, 'getBarang']);
// Route::post('/addImageBarang', [PostControllerBarang::class, 'upload']);
// Route::get('/removeImageBarang/{id}', [PostControllerBarang::class, 'remove']);
