<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeltPackageController;

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
//Proccess on inventory
Route::post('/melt-init', [MeltPackageController::class, 'melt_init']);
Route::get('/melt-sequence', [MeltPackageController::class, 'melt_sequence']);
Route::get('/melt-created', [MeltPackageController::class, 'created_melt']);
Route::get('/melt-details/{bc}', [MeltPackageController::class, 'melt_detail']);
Route::get('/melt-info/{bc}', [MeltPackageController::class, 'melt_information']);
Route::post('/melt-send', [MeltPackageController::class, 'melt_sendtojujo']);
Route::post('/melt-return', [MeltPackageController::class, 'box_return']);
Route::post('/melt-finish', [MeltPackageController::class, 'melt_finish']);

// proccess on jujo
Route::get('/melt-receive', [MeltPackageController::class, 'melt_receive']);
Route::get('/melt-sending', [MeltPackageController::class, 'melt_sending']);
Route::post('/melt-process', [MeltPackageController::class, 'melt_process']);
Route::get('/melt-reduce/{bc}', [MeltPackageController::class, 'melt_reduce']);
Route::get('/melt_proccessed', [MeltPackageController::class, 'melt_proccessed']);
Route::get('/melt_preproccess_detail/{bc}', [MeltPackageController::class, 'melt_preprocess_detail']);
Route::post('/melt_get_proccessed', [MeltPackageController::class, 'getProccessed']);
Route::post('/melt_send_box', [MeltPackageController::class, 'melt_send_box']);
