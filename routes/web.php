<?php

// use App\Models\MeltPackage;

use App\Http\Controllers\MeltPackageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\MeltPackageController;

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
    // $data['page_title'] = 'QCVentory';
    // return view('Templatez.index', $data);
    $bcstatus  = DB::table('melt_current_status')->select("*")->get();
    // dd($bcstatus);
    return view('dashboard', compact('bcstatus'));
});
// Route Inventory
Route::group(['prefix' => 'Inventory'], function () {
    Route::get('/', function () {
        $data['page_title'] = 'Melting-Inventory';
        return view('Melting.index', $data);
    })->name('inventory.index');
});
// Route Jujo

// Route Melting
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

    Route::get('/daily-report', function () {
        $data['page_title'] = 'Melting-Daily-Report';
        $data['reports'] = (new MeltPackageController)->dailyReport();
        return view('Melting.daily-report', $data);
    })->name('melting.daily-report');
    // Route::get('/daily-report', [MeltPackageController::class, 'dailyReport'])->name('melting.daily-report');
});
