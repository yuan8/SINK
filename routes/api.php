<?php

use Illuminate\Http\Request;

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

Route::prefix('box/{tahun?}')->middleware(['bindTahun'])->group(function () {
	Route::post('/rkpd','DASHBOARD\HomeCtrl@rkpd')->name('d.box.rkpd');
	Route::post('/kebijakan','DASHBOARD\HomeCtrl@jumlah_kebijakan')->name('d.box.kebijakan');
	Route::post('/masalah','DASHBOARD\HomeCtrl@permasalahan')->name('d.box.permasalahan');
	Route::post('/rekomendasi','DASHBOARD\HomeCtrl@rekomendasi')->name('d.box.rekomendasi');





});