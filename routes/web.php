<?php

use App\Models\MeltPackage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeltPackageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $data['page_title'] = 'QCVentory';
    return view('Templatez.index', $data);
});

// Route Melting
Route::group(['prefix' => 'Melt'], function () {
    Route::get('/', function () {
        $data['page_title'] = 'Melting-Inventory';
        return view('Melting.index', $data);
    })->name('melting.index');

    Route::get('/info/{bc}', function ($bc) {
        $data['page_title'] = 'Melt-Information';
        $data['barcode'] = $bc;
        return view('Melting.info', $data);
    })->name('melting.info');
});

Route::group(['prefix' => 'Jujo'], function () {
    Route::get('/', function () {
        $data['page_title'] = 'Melting-Jujo';
        return view('Melting.jujo', $data);
    })->name('melting.jujo');

    Route::get('/box', function () {
        $data['page_title'] = "Melting-Jujo-Box";
        return view('Melting.jujo-box', $data);
    })->name('melting.jujo-box');
});
