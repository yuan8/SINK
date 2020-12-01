<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('mogo',function(){
	$data=['
	_id'=>'djskjdksj',
	'data'=>'jdkjskdjkdjk djskjdk'

	];
	$db=DB::connection('mongodb')->collection('def')
  	->insertGetId($data);
});

Route::prefix('sinkronisasi/{tahun?}')->middleware(['bindTahun'])->group(function () {
	Route::get('/','SINK\HomeCtrl@index')->name('sink.index');
	Route::get('/ubah-tahun-access','SINK\HomeCtrl@tahun_acces')->name('sink.form.tahun_acces');
	Route::post('/ubah-tahun-access','SINK\HomeCtrl@ubah_tahun_access')->name('sink.form.ubah_tahun');

	Route::get('/ubah-urusan','SINK\HomeCtrl@ubah_urusan')->name('sink.form.ubah_urusan');

});

Route::prefix('initial/{tahun?}')->group(function () {
	Route::get('/initial-db','SINK\InitCtrl@init');
	Route::get('/nomen-db','SINK\NOMENKLATURCTRL@provinsi');

});

Route::prefix('sinkronisasi-admin/{tahun?}')->middleware(['bindTahun','auth:web','can:accessAdmin'])->group(function () {
	Route::get('/','ADMIN\HomeCtrl@index')->name('sink.admin.index');
	Route::get('/sdgs','ADMIN\SDGSCTRL@index')->name('sink.admin.sdgs.index');
	Route::get('/sdgs/form-add/{id?}','ADMIN\SDGSCTRL@add')->name('sink.admin.sdgs.add');
	Route::post('/sdgs/form-store/{id?}','ADMIN\SDGSCTRL@store')->name('sink.admin.sdgs.store');






});

Route::prefix('sinkronisasi-pusat/{tahun?}')->middleware(['bindTahun','auth:web','bindUrusan','can:accessPusat'])->group(function () {
	Route::get('/','PUSAT\HomeCtrl@index')->name('sink.pusat.index');
	// kebiajakan
	Route::get('/kebijakan','PUSAT\KEBIJAKANCTRL@index')->name('sink.pusat.kebijakan.index');
	Route::get('/kebijakan/mandat/edit/{id}','PUSAT\KEBIJAKANCTRL@edit')->name('sink.pusat.kebijakan.mandat.edit');
	Route::post('/kebijakan/mandat/edit/{id}','PUSAT\KEBIJAKANCTRL@update')->name('sink.pusat.kebijakan.mandat.update');
	Route::get('/kebijakan/mandat/hapus/{id}','PUSAT\KEBIJAKANCTRL@form_del')->name('sink.pusat.kebijakan.mandat.form_del');
	Route::post('/kebijakan/mandat/hapus/{id}','PUSAT\KEBIJAKANCTRL@delete')->name('sink.pusat.kebijakan.mandat.del');
	Route::post('/kebijakan/mandat/store','PUSAT\KEBIJAKANCTRL@store')->name('sink.pusat.kebijakan.mandat.store');
	Route::get('/kebijakan/mandat/add/kb/{id}/{context}','PUSAT\KEBIJAKANCTRL@create_kb')->name('sink.pusat.kebijakan.mandat.add.kb');
	Route::post('/kebijakan/mandat/add/kb/{id}/{context}','PUSAT\KEBIJAKANCTRL@store_kb')->name('sink.pusat.kebijakan.mandat.store.kb');

	// kb pusat
	Route::get('/kebijakan/kb/edit/{id}','PUSAT\KEBIJAKANCTRL@edit_kb')->name('sink.pusat.kebijakan.edit_kb');

	Route::post('/kebijakan/kb/edit/{id}','PUSAT\KEBIJAKANCTRL@update_kb')->name('sink.pusat.kebijakan.update_kb');

	Route::get('/kebijakan/kb/delete/{id}','PUSAT\KEBIJAKANCTRL@form_del_kb')->name('sink.pusat.kebijakan.kb.form.del');

	Route::post('/kebijakan/kb/delete/{id}','PUSAT\KEBIJAKANCTRL@delete_kb')->name('sink.pusat.kebijakan.kb.del');


	//	kebijakan daerah
	Route::get('/kebijakan-daerah','PUSAT\KEBIJAKANDEARAHCTRL@index')->name('sink.pusat.kebijakandaerah.index');

	// rkpd

	Route::get('rkpd','PUSAT\RKPDCTRL@index')->name('sink.pusat.rkpd.index');

	Route::get('rkpd-rekomendasi','PUSAT\RKPDCTRL@rekomendasi')->name('sink.pusat.rkpd.rekomendasi.index');


	// kebjakan 5 tahun
	Route::get('/kebijakan-5-tahunan','PUSAT\KEBIJAKAN5CTRL@index')->name('sink.pusat.kebijakan5.index');

	Route::get('/kebijakan-5-tahunan/item/add/{id?}','PUSAT\KEBIJAKAN5CTRL@add_item')->name('sink.pusat.kebijakan5.add');

	Route::post('/kebijakan-5-tahunan/item/add/{id?}','PUSAT\KEBIJAKAN5CTRL@store_item')->name('sink.pusat.kebijakan5.store');

	Route::get('/kebijakan-5-tahunan/form/edit/{id}','PUSAT\KEBIJAKAN5CTRL@edit')->name('sink.pusat.kebijakan5.edit');

	Route::post('/kebijakan-5-tahunan/form/edit/{id}','PUSAT\KEBIJAKAN5CTRL@update')->name('sink.pusat.kebijakan5.update');

	Route::get('/kebijakan-5-tahunan/form/hapus/{id}','PUSAT\KEBIJAKAN5CTRL@form_delete')->name('sink.pusat.kebijakan5.form.delete');

	Route::post('/kebijakan-5-tahunan/form/hapus/{id}','PUSAT\KEBIJAKAN5CTRL@delete')->name('sink.pusat.kebijakan5.delete');

	Route::get('/kebijakan-5-tahunan/form/hapus-indikator/{id}','PUSAT\KEBIJAKAN5CTRL@form_delete_indikator')->name('sink.pusat.kebijakan5.form.delete.indikator');

	Route::post('/kebijakan-5-tahunan/form/hapus-indikator/{id}','PUSAT\KEBIJAKAN5CTRL@hapus_indikator')->name('sink.pusat.kebijakan5.delete.indikator');


	Route::get('/kebijakan-5-tahunan/form-tambah/indikator','PUSAT\KEBIJAKAN5CTRL@tambah_indikator')->name('sink.pusat.kebijakan5.form.ind.tagging');

	Route::post('/kebijakan-5-tahunan/tambah/indikator','PUSAT\KEBIJAKAN5CTRL@store_indikator')->name('sink.pusat.kebijakan5.ind.tagging');

	// kebijakan 1 tahun
		Route::get('/kebijakan-1-tahunan','PUSAT\KEBIJAKAN1CTRL@index')->name('sink.pusat.kebijakan1.index');

		Route::get('/kebijakan-1-tahunan/item/add/{id?}','PUSAT\KEBIJAKAN1CTRL@tambah')->name('sink.pusat.kebijakan1.form_tambah');

		Route::get('/kebijakan-1-tahunan/item/add-indikator/{id}','PUSAT\KEBIJAKAN1CTRL@tambah_indikator')->name('sink.pusat.kebijakan1.form.ind.form_tambah');

		Route::post('/kebijakan-1-tahunan/item/add-indikator/{id}','PUSAT\KEBIJAKAN1CTRL@store_indikator')->name('sink.pusat.kebijakan1.ind.tagging');

		Route::get('/kebijakan-1-tahunan/item/edit/{id}','PUSAT\KEBIJAKAN1CTRL@edit')->name('sink.pusat.kebijakan1.form.edit');

		Route::post('/kebijakan-1-tahunan/item/edit/{id}','PUSAT\KEBIJAKAN1CTRL@update')->name('sink.pusat.kebijakan1.update');

		Route::get('/kebijakan-1-tahunan/item/delete/{id}','PUSAT\KEBIJAKAN1CTRL@form_hapus')->name('sink.pusat.kebijakan1.form.delete');

		Route::get('/kebijakan-1-tahunan/item/indikator/delete/{id}','PUSAT\KEBIJAKAN1CTRL@form_hapus_indikator')->name('sink.pusat.kebijakan1.form.delete.indikator');

		Route::post('/kebijakan-1-tahunan/item/indikator/delete/{id}','PUSAT\KEBIJAKAN1CTRL@hapus_indikator')->name('sink.pusat.kebijakan1.delete.indikator');


		Route::post('/kebijakan-1-tahunan/item/delete/{id}','PUSAT\KEBIJAKAN1CTRL@delete')->name('sink.pusat.kebijakan1.delete');

		Route::post('/kebijakan-1-tahunan/item/add/{id?}','PUSAT\KEBIJAKAN1CTRL@store')->name('sink.pusat.kebijakan1.store');



	// indikator
	Route::get('/master-indikator','PUSAT\MASTERINDIKATORCTRL@index')->name('sink.pusat.indikator.index');

	Route::get('/master-indikator/detail/{id}/child-line','PUSAT\MASTERINDIKATORCTRL@bridge')->name('sink.pusat.indikator.child_line');

	Route::get('/master-indikator/detail/{id}','PUSAT\MASTERINDIKATORCTRL@detail')->name('sink.pusat.indikator.detail');

	Route::get('/master-indikator/tambah','PUSAT\MASTERINDIKATORCTRL@create')->name('sink.pusat.indikator.create');

	Route::post('/master-indikator/store','PUSAT\MASTERINDIKATORCTRL@store')->name('sink.pusat.indikator.store');

	Route::get('/master-indikator/form/edit/{id}','PUSAT\MASTERINDIKATORCTRL@edit')->name('sink.pusat.indikator.form.edit');

	Route::post('/master-indikator/form/edit/{id}','PUSAT\MASTERINDIKATORCTRL@update')->name('sink.pusat.indikator.update');

	Route::get('/master-indikator/form/hapus/{id}','PUSAT\MASTERINDIKATORCTRL@form_delete')->name('sink.pusat.indikator.form.delete');

	Route::post('/master-indikator/form/hapus/{id}','PUSAT\MASTERINDIKATORCTRL@delete')->name('sink.pusat.indikator.delete');

	// schedule
	Route::get('/schedule-desk','PUSAT\SCHEDULEDESKCTRL@index')->name('sink.pusat.schedule-desk.index');

		// permasalahan
	Route::get('/masalah-pemda','PUSAT\PERMASALAHANPEMDACTRL@index')->name('sink.pusat.permasalahan.index');


	// sdgs
	Route::get('/sdgs','PUSAT\SDGSCTRL@index')->name('sink.pusat.sdgs.index');
	Route::get('/sdgs/add/{id}','PUSAT\SDGSCTRL@add')->name('sink.pusat.sdgs.add');
	Route::post('/sdgs/add/{id}','PUSAT\SDGSCTRL@store')->name('sink.pusat.sdgs.store');



});

Route::prefix('sinkronisasi-daerah/{tahun?}')->middleware(['bindTahun','auth:web','can:alive'])->group(function () {
	Route::get('init','DAERAH\HomeCtrl@init')->name('sink.daerah.init');
	Route::post('init','DAERAH\HomeCtrl@update_pemda')->name('sink.daerah.init_update');


	Route::prefix('{kodepemda}/{menu_context?}')->middleware(['bindTahun','auth:web','bindPemda'])->group(function(){
		Route::get('/','DAERAH\HomeCtrl@index')->name('sink.daerah.index');

		// KEBIJAKAN
		Route::get('/kebijakan','DAERAH\KEBIJAKANCTRL@index')->name('sink.daerah.kebijakan.index');

		Route::get('/kebijakan/form/add/{id}','DAERAH\KEBIJAKANCTRL@add_item')->name('sink.daerah.kebijakan.form.add');

		Route::post('/kebijakan/form/add/{id}','DAERAH\KEBIJAKANCTRL@store')->name('sink.daerah.kebijakan.store');

		Route::get('/kebijakan-kegiatan','DAERAH\KEBIJAKANCTRL@kegiatan')->name('sink.daerah.kebijakan.kegiatan');

		Route::get('/kebijakan/form-edit/{id}','DAERAH\KEBIJAKANCTRL@edit')->name('sink.daerah.kebijakan.form.edit');

		Route::post('/kebijakan/form-edit/{id}','DAERAH\KEBIJAKANCTRL@update')->name('sink.daerah.kebijakan.update');

		Route::get('/kebijakan/form-delete/{id}','DAERAH\KEBIJAKANCTRL@form_delete')->name('sink.daerah.kebijakan.form.delete');

		Route::post('/kebijakan/form-delete/{id}','DAERAH\KEBIJAKANCTRL@delete')->name('sink.daerah.kebijakan.delete');

		Route::get('/kebijakan/form-penilaian-edit/{id}','DAERAH\KEBIJAKANCTRL@penilaian')->name('sink.daerah.kebijakan.form.penilaian.edit');

		Route::post('/kebijakan/form-penilaian-edit/{id}','DAERAH\KEBIJAKANCTRL@penilaian_update')->name('sink.daerah.kebijakan.penilaian.update');




		//

		// INDIKATOR
		Route::get('/master-indikator','DAERAH\MASTERINDIKATORCTRL@index')->name('sink.daerah.indikator.index');

	// rkpd
		Route::get('/rkpd','DAERAH\RKPDCTRL@index')->name('sink.daerah.rkpd.index');
		Route::get('/rkpd/form-edit/progress/{id}','DAERAH\RKPDCTRL@edit_progres')->name('sink.daerah.rkpd.edit_progres');

		Route::post('/rkpd/form-edit/progress/{id}','DAERAH\RKPDCTRL@update_progres')->name('sink.daerah.rkpd.progres.update');



		// schedule
		Route::get('/schedule-desk','PUSAT\SCHEDULEDESKCTRL@index')->name('sink.daerah.schedule-desk.index');

		// permasalahan
		Route::get('/masalah-pemda','DAERAH\PERMASALAHANPEMDACTRL@index')->name('sink.daerah.permasalahan.index');

		Route::get('/masalah-pemda/form/tambah/{id?}','DAERAH\PERMASALAHANPEMDACTRL@add_item')->name('sink.daerah.permasalahan.form.add');

		Route::post('/masalah-pemda/form/tambah/{id?}','DAERAH\PERMASALAHANPEMDACTRL@store_item')->name('sink.daerah.permasalahan.store');

		Route::get('/masalah-pemda/form/edit/{id}','DAERAH\PERMASALAHANPEMDACTRL@edit')->name('sink.daerah.permasalahan.form.edit');

		Route::post('/masalah-pemda/form/edit/{id}','DAERAH\PERMASALAHANPEMDACTRL@update')->name('sink.daerah.permasalahan.update');

		Route::get('/masalah-pemda/form/delete/{id}','DAERAH\PERMASALAHANPEMDACTRL@form_delete')->name('sink.daerah.permasalahan.form.delete');

		Route::post('/masalah-pemda/form/delete/{id}','DAERAH\PERMASALAHANPEMDACTRL@delete')->name('sink.daerah.permasalahan.delete');

		// Rekomendasi

		Route::get('/rekomendasi/','DAERAH\REKOMENDASICTRL@index')->name('sink.daerah.rekomendasi.index');

		Route::get('rekomendasi/nomenklatur-list/{id?}','DAERAH\REKOMENDASICTRL@nomen_list_chose')->name('sink.daerah.rekomendasi.nomen_list_chose');

		Route::post('rekomendasi/nomenklatur-list/{id?}','DAERAH\REKOMENDASICTRL@store_rekomendasi')->name('sink.daerah.rekomendasi.nomen.store');

		Route::get('/rekomendasi/permasalahan-list/{id}','DAERAH\REKOMENDASICTRL@permasalahan_list_chose')->name('sink.daerah.rekomendasi.permasalahan_list_chose');

		Route::get('/rekomendasi/ind-list/{id}','DAERAH\REKOMENDASICTRL@indikator_list_chose')->name('sink.daerah.rekomendasi.ind_list');

		Route::post('/rekomendasi/ind-list/{id}','DAERAH\REKOMENDASICTRL@ind_store')->name('sink.daerah.rekomendasi.ind.store');

		Route::get('/rekomendasi/edit/{id}','DAERAH\REKOMENDASICTRL@edit')->name('sink.daerah.rekomendasi.edit');

		Route::post('/rekomendasi/update/{id}','DAERAH\REKOMENDASICTRL@update')->name('sink.daerah.rekomendasi.update');

		Route::get('/rekomendasi/form/delete/{id}','DAERAH\REKOMENDASICTRL@form_hapus')->name('sink.daerah.rekomendasi.form.delete');

		Route::post('/rekomendasi/form/delete/{id}','DAERAH\REKOMENDASICTRL@hapus')->name('sink.daerah.rekomendasi.delete');

	});




});

Route::prefix('data-master/{tahun}')->middleware(['bindTahun'])->group(function () {
	Route::middleware(['auth:web'])->group(function(){
		Route::get('/sumber-data-indikator','MASTERCTRL@get_sumber_data')->name('master.auth.sumber-data-indikator');

		Route::get('/satuan-data-indikator/{id?}','MASTERCTRL@satuan_indikator')->name('master.auth.satuan-data-indikator');
	});

	Route::middleware(['bindTahun','guest'])->group(function(){

	});


});

Route::prefix('sinkronisasi-rkpd-daerah')->middleware(['bindTahun','auth:web'])->group(function () {
	Route::get('/','DAERAH\HomeCtrl@index');

});

Auth::routes();

Route::get('/',function(){
	return redirect()->route('index');
});
Route::get('/home',function(){
	return redirect()->route('index');
});

Route::prefix('dashboard/{tahun?}')->middleware(['bindTahun'])->group(function () {
	Route::get('/','DASHBOARD\HomeCtrl@index')->name('index');
	Route::get('/rkpd','DASHBOARD\RKPDCTRL@index')->name('d.rkpd.index');
	Route::get('/rkpd/pelaporan','DASHBOARD\RKPDCTRL@pelaporan')->name('d.rkpd.pelaporan');

	Route::get('/rkpd/provinsi/{id}','DASHBOARD\RKPDCTRL@per_provinsi')->name('d.rkpd.per_provinsi');
	Route::get('/rkpd/detail/{id}','DASHBOARD\RKPDCTRL@detail')->name('d.rkpd.detail');

	Route::get('/kebijakan/','DASHBOARD\KEBIJAKANCTRL@index')->name('d.kebijakan.index');
	Route::get('/kebijakan-pusat/','DASHBOARD\KEBIJAKANCTRL@pusat')->name('d.kebijakan.pusat');

	Route::get('/kebijakan-pusat/implementasi-pemda/{id}','DASHBOARD\KEBIJAKANCTRL@implementasi_pemda')->name('d.kebijakan.implementasi_pemda');


	Route::get('/kebijakan/provinsi/{id}','DASHBOARD\KEBIJAKANCTRL@per_provinsi')->name('d.kebijakan.per_provinsi');

	Route::get('/kebijakan/detail/{id}','DASHBOARD\KEBIJAKANCTRL@detail')->name('d.kebijakan.detail');

	Route::get('/rpjmn/pusat/','DASHBOARD\RPJMNCtrl@pusat')->name('d.rpjmn.pusat');

	Route::get('/rpjmn/pusat/indikator','DASHBOARD\RPJMNCtrl@index')->name('d.rpjmn.indikator');

	Route::get('/rkp/pusat/','DASHBOARD\RPJMNCtrl@pusat')->name('d.rkp.pusat');

	Route::get('/rkp/pusat/indikator','DASHBOARD\RKPCtrl@index')->name('d.rkp.indikator');

	Route::get('/sdgs/pusat/indikator','DASHBOARD\RKPCtrl@index')->name('d.rkp.indikator');

	Route::get('/sdgs/pusat/indikator','DASHBOARD\RKPCtrl@index')->name('d.rkp.indikator');

	Route::get('/indikator/pusat','DASHBOARD\RKPCtrl@index')->name('d.rkp.indikator');








});
