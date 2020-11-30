<?php

namespace App\Http\Controllers\SINK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\SINK\InitRkpdCtrl;
use App\Http\Controllers\SINK\NOMENKLATURCTRL;

use YT;
class InitCtrl extends Controller
{
    public function init($tahun){
      set_time_limit(-1);
      static::tahun_access($tahun);
    	static::scheduler_desk($tahun);
    	static::sumber_indikator($tahun);
    	static::kebijakan($tahun);
    	static::rpjmn($tahun);
    	static::rkp($tahun);
    	static::kewenangan($tahun);
    	static::indikator($tahun);
    	static::kewenangan_bridge($tahun);
    	static::permasalahan($tahun);

      static::nomenklatur($tahun);
    	static::rekomendasi($tahun);
    	static::rekomendasi_indikator($tahun);
      static::bridge_indikator_pusat($tahun);
      InitRkpdCtrl::init($tahun,true);
      static::dukungan_pusat_indikator($tahun);
      static::nested_indikator($tahun);
      static::nspk_rekomendasi($tahun);
      // NOMENKLATURCTRL::init($tahun);

      DB::table('sink_form.t_'.$tahun.'_nomenklatur')->where('id_urusan',2)->update([
          'id_urusan'=>3
      ]);

    	return 'done !, database '.$tahun.' sinkronisasi created';

    }

    static function nspk_rekomendasi($tahun=2020){
        if(!Schema::connection('sink_form')->hasTable('sink_form.td_'.$tahun.'_rekomendasi_nspk')){
            Schema::create('sink_form.td_'.$tahun.'_rekomendasi_nspk',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');
                $table->bigInteger('id_penilaian');
                $table->bigInteger('id_rekomendasi');
                $table->integer('tahun')->defautl($tahun);
                $table->string('kodepemda')->nullable();
                $table->bigInteger('id_user_created')->nullable();
                $table->bigInteger('id_user_update')->nullable();
                $table->timestamps();

                $table->foreign('id_penilaian')
                  ->references('id')->on('sink_form.td_'.$tahun.'_kb_penilaian')
                  ->onDelete('cascade');

                $table->foreign('id_rekomendasi')
                  ->references('id')->on('sink_form.td_'.$tahun.'_rekomendasi')
                  ->onDelete('cascade');



            });
        }
    }

    static function nested_indikator($tahun=2020){
        if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_nested_indikator_bridge')){
            Schema::create('sink_form.t_'.$tahun.'_nested_indikator_bridge',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');

                $table->bigInteger('id_parent')->unsigned();
                $table->bigInteger('id_indikator')->unsigned();
                $table->bigInteger('id_user_created')->nullable();
                $table->bigInteger('id_user_update')->nullable();
                $table->timestamps();

                $table->foreign('id_parent')
                  ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                  ->onDelete('cascade');
                $table->foreign('id_indikator')
                  ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                  ->onDelete('cascade');
            });
        }
    }

     static function dukungan_pusat_indikator($tahun=2020){
        if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_dukungan_pusat')){
            Schema::create('sink_form.t_'.$tahun.'_dukungan_pusat',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');
                $table->integer('tahun')->default($tahun);
                $table->text('uraian');
                $table->string('jenis_data');
                $table->string('jenis');
                $table->mediumText('pelaksana')->nullable();
                $table->bigInteger('id_parent')->nullable();
                $table->bigInteger('id_user_created')->nullable();
                $table->bigInteger('id_user_update')->nullable();
                $table->timestamps();

                $table->foreign('id_parent')
                  ->references('id')->on('sink_form.t_'.$tahun.'_dukungan_pusat')
                  ->onDelete('cascade');
            });
        }

         if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_dukungan_pusat_indikator_bridge')){
            Schema::create('sink_form.t_'.$tahun.'_dukungan_pusat_indikator_bridge',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');
                $table->integer('tahun')->defautl($tahun);
                $table->bigInteger('id_indikator')->defautl($tahun);
                $table->bigInteger('id_dukungan_pusat')->defautl($tahun);

                $table->foreign('id_dukungan_pusat')
                  ->references('id')->on('sink_form.t_'.$tahun.'_dukungan_pusat')
                  ->onDelete('cascade');

                $table->foreign('id_indikator')
                  ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                  ->onDelete('cascade');
            });
        }
    }



    static function scheduler_desk($tahun=2020){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_scheduler_desk')){
    		Schema::create('sink_form.t_'.$tahun.'_scheduler_desk',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->string('jenis');
    			$table->dateTime('start');
    			$table->dateTime('end');
    			$table->integer('tahun')->defautl($tahun);
    			$table->mediumText('keterangan')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    		});

    		DB::table('sink_form.t_'.$tahun.'_scheduler_desk')->insert([
    			[
    				'id'=>1,
    				'jenis'=>'KEBIJAKAN_PUSAT',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(1),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>2,
    				'jenis'=>'KEBIJAKAN_DAERAH',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(2),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>3,
    				'jenis'=>'RPJMN',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(1),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>4,
    				'jenis'=>'RKP',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(1),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>5,
    				'jenis'=>'INDIKATOR',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(2),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>6,
    				'jenis'=>'KEWENANGAN',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(2),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>7,
    				'jenis'=>'REKOMENDASI_RKPD_DAERAH',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(3),
    				'tahun'=>$tahun
    			],
    			[
    				'id'=>8,
    				'jenis'=>'PERMASALAHAN_DAERAH',
    				'start'=>YT::now(),
    				'end'=>YT::now()->addMonths(3),
    				'tahun'=>$tahun
    			],


    		]);

    	}

    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_status_form')){
    		Schema::create('sink_form.t_'.$tahun.'_status_form',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('kodepemda');
    			$table->integer('tahun')->defautl($tahun);
    			$table->string('jenis');
    			$table->string('status');
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    		});

    	}

    }

      static function tahun_access($tahun=2020){

        if(!Schema::connection('sink_form')->hasTable('sink_form.tahun_access')){
            Schema::create('sink_form.tahun_access',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');
                $table->bigInteger('tahun')->unique();
                $table->string('rpjmn')->nullable();
                $table->string('rkp')->nullable();
                $table->string('indikator_kinerja_pemda')->nullable();
                $table->timestamps();

            });
        }

        DB::table('sink_form.tahun_access')->insertOrIgnore([
            'tahun'=>$tahun,
        ]);
    }

    static function kebijakan($tahun=2020){

    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_kb_mandat')){
    		Schema::create('sink_form.t_'.$tahun.'_kb_mandat',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan');
                $table->string('jenis');
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('uraian');
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    		});

    	}

    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_kb')){
    		Schema::create('sink_form.t_'.$tahun.'_kb',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan');
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('jenis');
    			$table->integer('tahun_berlaku');
    			$table->text('uraian');
    			$table->bigInteger('id_mandat')->unsigned();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    			$table->foreign('id_mandat')
			      ->references('id')->on('sink_form.t_'.$tahun.'_kb_mandat')
			      ->onDelete('cascade');

    		});

    	}

    	if(!Schema::connection('sink_form')->hasTable('sink_form.td_'.$tahun.'_kb_penilaian')){
    		Schema::create('sink_form.td_'.$tahun.'_kb_penilaian',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->integer('tahun')->defautl($tahun);
    			$table->string('kodepemda',4);
    			$table->integer('penilaian')->default(0);
    			$table->bigInteger('id_mandat')->unsigned();
    			$table->mediumText('uraian_note')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();
    			$table->unique(['kodepemda','id_mandat','tahun','id_urusan','id_sub_urusan']);
    			$table->foreign('id_mandat')
			      ->references('id')->on('sink_form.t_'.$tahun.'_kb_mandat')
			      ->onDelete('cascade');

    		});

    	}

    	if(!Schema::connection('sink_form')->hasTable('sink_form.td_'.$tahun.'_kb')){
    		Schema::create('sink_form.td_'.$tahun.'_kb',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
                $table->string('kodepemda',4);
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('jenis');
    			$table->integer('tahun_berlaku');
    			$table->text('uraian');
    			$table->bigInteger('id_penilaian')->unsigned();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    			$table->foreign('id_penilaian')
			      ->references('id')->on('sink_form.td_'.$tahun.'_kb_penilaian')
			      ->onDelete('cascade');

    		});

    	}

    	return 1;

    }

    static function rpjmn($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_rpjmn')){
    		Schema::create('sink_form.t_'.$tahun.'_rpjmn',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('kode')->nullable();
    			$table->text('jenis');
    			$table->text('uraian');

    			$table->mediumText('keterangan')->nullable();
                $table->bigInteger('id_parent')->nullable();

    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['kode','tahun','id_urusan','id_sub_urusan']);
    			$table->timestamps();

                $table->foreign('id_parent')
                  ->references('id')->on('sink_form.t_'.$tahun.'_rpjmn')
                  ->onDelete('cascade');


    		});

    	}

    }

    static function rkp($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_rkp')){
    		Schema::create('sink_form.t_'.$tahun.'_rkp',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('kode')->nullable();
    			$table->text('jenis');
    			$table->text('uraian');
    			$table->mediumText('keterangan')->nullable();
                $table->bigInteger('id_parent')->nullable();

    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['kode','tahun','id_urusan','id_sub_urusan']);
    			$table->timestamps();

                $table->foreign('id_parent')
                  ->references('id')->on('sink_form.t_'.$tahun.'_rkp')
                  ->onDelete('cascade');

    		});

    	}
    }


    static function sumber_indikator($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_sumber_data')){
    		Schema::create('sink_form.t_'.$tahun.'_sumber_data',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('kode')->nullable();
    			$table->text('jenis');
    			$table->text('uraian');
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['uraian','tahun']);
    			$table->timestamps();

    		});

    		DB::table('sink_form.t_'.$tahun.'_sumber_data')->insert([
    			[
    				'id'=>1,
    				'tahun'=>$tahun,
    				'kode'=>'RPJMN.'.$tahun,
    				'jenis'=>'RPJMN',
    				'uraian'=>'RPJMN (2019 - 2024)',
    			],
    			[
    				'id'=>2,
    				'tahun'=>$tahun,
    				'kode'=>'RKP.'.$tahun,
    				'jenis'=>'RKP',
    				'uraian'=>'RKP ('.$tahun.')',
    			]
    		]);



    	}
    }

     static function kewenangan($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_kewenangan')){
    		Schema::create('sink_form.t_'.$tahun.'_kewenangan',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->integer('tahun')->defautl($tahun);
    			$table->mediumText('kw_pusat')->nullable();
    			$table->mediumText('kw_provinsi')->nullable();
    			$table->mediumText('kw_kota')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    		});

    	}
    }


    static function indikator($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_indikator')){
    		Schema::create('sink_form.t_'.$tahun.'_indikator',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->bigInteger('id_sumber')->nullable();
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('kode')->nullable();
    			$table->string('jenis')->nullable();
    			$table->text('tolokukur');
    			$table->boolean('positiv_value')->defautl(true);
    			$table->text('target')->nullable();
    			$table->text('target_2')->nullable();
    			$table->text('satuan')->nullable();
    			$table->text('cara_hitung')->nullable();
    			$table->text('path_img')->nullable();
    			$table->bigInteger('id_parent')->nullable();

    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['kode','tahun','id_urusan','id_sub_urusan']);

    			$table->foreign('id_sumber')
			      ->references('id')->on('sink_form.t_'.$tahun.'_sumber_data')
			      ->onDelete('cascade');

    			$table->timestamps();

    		});

    	}
    }

    static function bridge_indikator_pusat($tahun){
        if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_indikator_rpjmn_bridge')){
            Schema::create('sink_form.t_'.$tahun.'_indikator_rpjmn_bridge',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');
                $table->integer('tahun')->defautl($tahun);
                $table->bigInteger('id_rpjmn')->unsigned();
                $table->bigInteger('id_indikator')->unsigned();
                $table->mediumText('keterangan')->nullable();
                $table->bigInteger('id_user_created')->nullable();
                $table->bigInteger('id_user_update')->nullable();
                $table->timestamps();

                $table->foreign('id_rpjmn')
                  ->references('id')->on('sink_form.t_'.$tahun.'_rpjmn')
                  ->onDelete('cascade');

                $table->foreign('id_indikator')
                  ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                  ->onDelete('cascade');

            });

        }

          if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_indikator_rkp_bridge')){
            Schema::create('sink_form.t_'.$tahun.'_indikator_rkp_bridge',function(Blueprint $table) use ($tahun){
                $table->bigIncrements('id');
                $table->integer('tahun')->defautl($tahun);
                $table->bigInteger('id_rkp')->unsigned();
                $table->bigInteger('id_indikator')->unsigned();
                $table->mediumText('keterangan')->nullable();
                $table->bigInteger('id_user_created')->nullable();
                $table->bigInteger('id_user_update')->nullable();
                $table->timestamps();

                $table->foreign('id_rkp')
                  ->references('id')->on('sink_form.t_'.$tahun.'_rkp')
                  ->onDelete('cascade');

                $table->foreign('id_indikator')
                  ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                  ->onDelete('cascade');

            });

        }

    }

     static function kewenangan_bridge($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_kewenangan_bridge')){
    		Schema::create('sink_form.t_'.$tahun.'_kewenangan_bridge',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->integer('tahun')->defautl($tahun);
    			$table->bigInteger('id_kewenangan')->unsigned();
    			$table->bigInteger('id_indikator')->unsigned();
    			$table->mediumText('data_dukung')->nullable();
    			$table->mediumText('keterangan')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->timestamps();

    			$table->foreign('id_kewenangan')
			      ->references('id')->on('sink_form.t_'.$tahun.'_kewenangan')
			      ->onDelete('cascade');

			    $table->foreign('id_indikator')
			      ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
			      ->onDelete('cascade');

    		});

    	}
    }

    static function permasalahan($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.td_'.$tahun.'_permasalahan')){
    		Schema::create('sink_form.td_'.$tahun.'_permasalahan',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->string('kodepemda');
    			$table->bigInteger('id_urusan');
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->integer('tahun')->defautl($tahun);
                $table->text('uraian_sumber_data')->nullable();

    			$table->text('kode')->nullable();
                $table->text('kodedatarkpd')->nullable();
                $table->text('kategori')->nullable();
    			$table->text('jenis');
    			$table->mediumText('uraian');
                $table->mediumText('tindak_lanjut')->nullable();
                $table->bigInteger('id_parent')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['kode','tahun','id_urusan','id_sub_urusan']);
    			$table->timestamps();

                $table->foreign('id_parent')
                  ->references('id')->on('sink_form.td_'.$tahun.'_permasalahan')
                  ->onDelete('cascade');

    		});

    	}
    }

    static function nomenklatur($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.t_'.$tahun.'_nomenklatur')){
    		Schema::create('sink_form.t_'.$tahun.'_nomenklatur',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->bigInteger('id_urusan')->nullable();
    			$table->bigInteger('id_sub_urusan')->nullable();
    			$table->integer('tahun')->defautl($tahun);
    			$table->text('kode')->nullable();
                $table->text('kode_urusan')->nullable();
                $table->text('kode_bidang')->nullable();
                $table->text('kode_program')->nullable();
                $table->text('kode_kegiatan')->nullable();
    			$table->text('jenis');
    			$table->text('uraian');
                $table->boolean('provinsi')->defautl(true);
    			$table->bigInteger('id_parent')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['kode','provinsi','tahun']);
    			$table->timestamps();

    			$table->foreign('id_parent')
			      ->references('id')->on('sink_form.t_'.$tahun.'_nomenklatur')
			      ->onDelete('cascade');

    		});

    	}
    }


    static function rekomendasi($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.td_'.$tahun.'_rekomendasi')){
    		Schema::create('sink_form.td_'.$tahun.'_rekomendasi',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->string('kodepemda');
    			$table->bigInteger('id_urusan')->nullable();
    			$table->bigInteger('id_sub_urusan')->nullable();

    			$table->integer('tahun')->defautl($tahun);
    			$table->text('kode')->nullable();
    			$table->bigInteger('id_nomenklatur')->unsigned();
    			$table->bigInteger('id_parent')->nullable();
                $table->bigInteger('id_ms')->nullable();
    			$table->double('pagu',25,3)->nullable();
    			$table->mediumText('keterangan')->nullable();

    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();

    			$table->unique(['kode','id_nomenklatur','tahun','kodepemda','id_ms']);
    			$table->timestamps();

    			$table->foreign('id_nomenklatur')
			      ->references('id')->on('sink_form.t_'.$tahun.'_nomenklatur')
			      ->onDelete('cascade');

                $table->foreign('id_ms')
                  ->references('id')->on('sink_form.td_'.$tahun.'_permasalahan')
                  ->onDelete('cascade');

			    $table->foreign('id_parent')
			      ->references('id')->on('sink_form.td_'.$tahun.'_rekomendasi')
			      ->onDelete('cascade');

    		});

    	}


    }

    static function rekomendasi_indikator($tahun){
    	if(!Schema::connection('sink_form')->hasTable('sink_form.td_'.$tahun.'_rekomendasi_indikator')){
    		Schema::create('sink_form.td_'.$tahun.'_rekomendasi_indikator',function(Blueprint $table) use ($tahun){
    			$table->bigIncrements('id');
    			$table->string('kodepemda');
    			$table->integer('tahun')->defautl($tahun);
    			$table->bigInteger('id_rekomendasi')->unsigned();
    			$table->bigInteger('id_indikator')->nullable();
    			$table->double('pagu',25,3)->nullable();
    			$table->text('target')->nullable();
    			$table->text('target_2')->nullable();
    			$table->mediumText('keterangan')->nullable();
    			$table->bigInteger('id_user_created')->nullable();
    			$table->bigInteger('id_user_update')->nullable();
    			$table->unique(['id_indikator','id_rekomendasi','kodepemda']);
    			$table->timestamps();

    			$table->foreign('id_rekomendasi')
			      ->references('id')->on('sink_form.td_'.$tahun.'_rekomendasi')
			      ->onDelete('cascade');



    		});

    	}
    }

    // rkpd exist

}
