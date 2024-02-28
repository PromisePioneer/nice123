<?php

use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\Master\DistributorController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('web')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('master/barang')->controller(BarangController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('search', 'search');
    });

    Route::prefix('transaksi/barang-masuk')->controller(BarangMasukController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/data-barang', 'barangData');
        Route::get('/data-distributor', 'distributorData');
        Route::get('search', 'search');
        Route::get('/create', 'create');
        Route::post('/', 'store');
        Route::get('/showDistributorDetail', 'showDistributorDetail');
        Route::get('/{barangMasuk}', 'edit');
        Route::get('detail/{barangMasuk}', 'detail');
        Route::put('/{barangMasuk}','update');
        Route::delete('/{barangMasuk}','destroy');
        Route::get('/invoice/{barangMasuk}', 'invoice');
        Route::post('/update-status/{barangMasuk}', 'updateStatus');
        Route::get('/cetak-laporan/{tglAwal}/{tglAkhir}', 'laporan');
    });
    Route::prefix('transaksi/barang-keluar')->controller(BarangKeluarController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/data-barang', 'dataBarang');
        Route::get('/data-distributor', 'distributorData');
        Route::get('search', 'search');
        Route::get('/create', 'create');
        Route::post('/', 'store');
        Route::get('/showDistributorDetail', 'showDistributorDetail');
        Route::get('edit/{barangKeluar}', 'edit');
        Route::get('detail/{barangKeluar}', 'detail');
        Route::put('update/{barangKeluar}','update');
        Route::delete('/{barangKeluar}','destroy');
        Route::get('/invoice/{barangKeluar}', 'invoice');
        Route::post('/update-status/{barangKeluar}', 'updateStatus');
    });


    Route::prefix('laporan')->controller(\App\Http\Controllers\LaporanController::class)->group(function () {
        Route::get('/barang-masuk', 'laporanBarangMasuk');
        Route::get('/cetak-laporan/barang-masuk/{tglAwal}/{tglAkhir}', 'laporanBarangMasukPdf');
        Route::get('/barang-masuk/all', 'laporanBarangMasukPdfAll');
        Route::get('/barang-keluar', 'laporanBarangKeluar');
        Route::get('/barang-keluar/all', 'laporanBarangKeluarPdfAll');
        Route::get('/cetak-laporan/barang-keluar/{tglAwal}/{tglAkhir}', 'laporanBarangKeluarPdf');
    });
});

Route::middleware('role:owner')->group(function () {
    Route::prefix('user/permission')->controller(PermissionController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('search', 'search');
        Route::post('/', 'store');
        Route::get('/{permission}', 'edit');
        Route::post('/{permission}','update');
        Route::delete('/{permission}','destroy');
    });
    Route::prefix('user/role')->controller(RoleController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('search', 'search');
        Route::post('/', 'store');
        Route::get('/{role}', 'edit');
        Route::put('/{role}','update');
        Route::delete('/{role}','destroy');
    });
    Route::prefix('user/user')->controller(UserController::class)->group( function () {
        Route::get('/', 'index')->name('user.index');
        Route::get('/data', 'data');
        Route::get('search', 'search');
        Route::get('/create', 'create');
        Route::get('/role-data', 'roleData');
        Route::post('/store', 'store');
        Route::get('/edit/{user}', 'edit');
        Route::put('update/{user}','update');
        Route::delete('/{user}','destroy');
    });


    Route::prefix('transaksi/barang-masuk')->controller(BarangMasukController::class)->group( function () {
        Route::post('/update-status/{transaksi}', 'updateStatus');
    });

    Route::prefix('barang-keluar')->controller(BarangKeluarController::class)->group( function () {
        Route::post('/update-status/{transaksi}', 'updateStatus');
    });

    Route::prefix('master/distributor')->controller(DistributorController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('search', 'search');
        Route::post('/', 'store');
        Route::get('/{distributor}', 'edit');
        Route::put('/{distributor}','update');
        Route::delete('/{distributor}','destroy');
    });

    Route::prefix('master/barang')->controller(BarangController::class)->group( function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/data-distributor', 'distData');
        Route::get('search', 'search');
        Route::post('/', 'store');
        Route::get('/{barang}', 'edit');
        Route::put('/{barang}','update');
        Route::delete('/{barang}','destroy');
    });
});
