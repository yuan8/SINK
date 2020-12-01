<?php

namespace App\Http\Controllers\SINK;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use DB;

class InitRkpdCtrl extends Controller
{



    public static function init($tahun,$console=false){
    	static::status($tahun);
    	static::bidang($tahun);
    	static::program($tahun);
    	static::program_capaian($tahun);

    	static::kegiatan($tahun);
    	static::kegiatan_indikator($tahun);
    	static::kegiatan_sumberdana($tahun);

    	static::sub_kegiatan($tahun);
        static::sub_kegiatan_indikator($tahun);
    	static::sub_kegiatan_sumberdana($tahun);
        static::view($tahun);
        // static::master_peta_indikator($tahun);
        static::peta_indikator_kegiatan($tahun);
        static::peta_indikator_program($tahun);
        static::peta_indikator_sub_kegiatan($tahun);
        static::permasalahan_rkpd($tahun);

        if($console){
            return 'initial database RKPD '.$tahun.' is done';
        }else{
            return back();
        }

    }


    static function rkpd_progress($tahun=2020){
        $schema='rkpd.';

         if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_progres_rkpd')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_progres_rkpd',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun');
                    $table->string('jenis');
                    $table->text('kodedata')->default('');
                    $table->mediumText('uraian_capaian')->nullable();
                    $table->float('pregres')->nullable();
                    $table->timestamps();
              });
          } 
    }

    static function rekomendasi_target($tahun=2020){
        $schema='rkpd.';

         if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_rekomendasi_target')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_rekomendasi_target',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun');
                    $table->string('jenis');
                    $table->text('kodedata')->default('');
                    $table->mediumText('uraian')->nullable();
                    $table->timestamps();
              });
          } 
    }



    static function permasalahan_rkpd($tahun){
    	  	 $schema='rkpd.';

         if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_permasalahan_rkpd')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_permasalahan_rkpd',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun');
                    $table->string('jenis');
                    $table->text('kodedata')->default('');
                    $table->mediumText('uraian')->nullable();
                    $table->string('category')->nullable();
                    $table->mediumText('tindaklanjut')->nullable();
                    $table->timestamps();
              });
          }
    }

    static function status($tahun){
    	 $schema='rkpd.';

         if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_status')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_status',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun');
                    $table->integer('status');
                    $table->integer('attemp')->default(0);
                    $table->text('tipe_pengambilan')->nullable();
                    $table->string('sumber_data')->nullable();
                    $table->string('method')->nullable();
                    $table->string('perkada')->nullable();
                    $table->string('nomenklatur')->nullable();
                    $table->double('pagu',25,3)->default(0);
                    $table->dateTime('last_date')->nullable();
                    $table->bigInteger('transactioncode')->nullable();
                    $table->boolean('matches')->nullable();
                    $table->timestamps();
              });
          }

        $schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_status_data')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_status_data',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun');
                    $table->integer('status');
                    $table->text('tipe_pengambilan')->nullable();
                    $table->string('sumber_data')->nullable();
                    $table->string('method')->nullable();
                    $table->string('perkada')->nullable();
                    $table->string('nomenklatur')->nullable();
                    $table->string('dokumen_path')->nullable();
                    $table->double('pagu',25,3)->default(0);
                    $table->dateTime('last_date')->nullable();
                    $table->bigInteger('transactioncode')->nullable();
                    $table->boolean('matches')->nullable();
                    $table->timestamps();


              });
        }
    }

    static function bidang($tahun){

		  $schema='rkpd.';


         if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_bidang')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_bidang',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('uraibidang')->nullable();
                    $table->bigInteger('id_urusan')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->string('uraiskpd')->nullable();
                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();

              });
          }



	}

	static function program($tahun){

		  $schema='rkpd.';

         if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_program')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_program',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->bigInteger('id_bidang')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('uraibidang')->nullable();
                    $table->string('kode_urusan_prioritas')->nullable();
                    $table->bigInteger('id_urusan')->nullable();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->string('kodeprogram')->nullable();
                    $table->text('uraiprogram')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->text('uraiskpd')->nullable();
                	$table->float('progress')->nullable()->default(0);
                	$table->mediumText('capaian')->nullable();
                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();
                    $table->foreign('id_bidang')
	                  ->references('id')->on($schema.'master_'.$tahun.'_bidang')
	                  ->onDelete('cascade')->onUpdate('cascade');
	                });
          }

	}


	static function program_capaian($tahun){
		 $schema='rkpd.';
		if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_program_capaian')){
          Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_program_capaian',function(Blueprint $table) use ($schema,$tahun){
                $table->bigIncrements('id');
                        $table->integer('status')->default(0);
                        $table->text('kodedata')->unique();
                        $table->bigInteger('id_bidang')->unsigned();
                        $table->bigInteger('id_program')->unsigned();
                        $table->string('kodepemda',4);
                        $table->integer('tahun');
                        $table->string('kodebidang')->nullable();
                        $table->string('kodeskpd')->nullable();
                        $table->string('kodeprogram')->nullable();
                        $table->string('kodekegiatan')->nullable();
                        $table->string('kodeindikator')->nullable();
                        $table->longText('tolokukur')->nullable();
                        $table->longText('satuan')->nullable();
                        $table->longText('target')->nullable();
                        $table->double('pagu',25,3)->default(0);
                        $table->double('anggaran',25,3)->default(0);
                        $table->double('realisasi_anggaran',25,3)->default(0);
                        $table->double('pagu_p',25,3)->default(0);
                        $table->longText('target_n1')->nullable();
                        $table->double('pagu_n1',25,3)->default(0);
                        $table->integer('jenis')->nullable();
                        $table->double('real_p4',25,3)->nullable();
                        $table->double('pagu_p4',25,3)->nullable();
                        $table->double('real_p3',25,3)->nullable();
                        $table->double('pagu_p3',25,3)->nullable();
                        $table->double('real_p2',25,3)->nullable();
                        $table->double('pagu_p2',25,3)->nullable();
                        $table->double('real_p1',25,3)->nullable();
                        $table->double('pagu_p1',25,3)->nullable();
                        $table->float('progress')->nullable()->default(0);
                        $table->mediumText('capaian')->nullable();

                        $table->double('target_penyesuaian',25,3)->nullable();
                        $table->boolean('cal')->default(false);
                        $table->integer('kode_lintas_urusan')->nullable();
                        $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();


		      	$table->foreign('id_program')
				      ->references('id')->on($schema.'master_'.$tahun.'_program')
				      ->onDelete('cascade')->onUpdate('cascade');
                 $table->foreign('id_bidang')
                      ->references('id')->on($schema.'master_'.$tahun.'_bidang')
                      ->onDelete('cascade')->onUpdate('cascade');
                  });
      }


	}

	static function program_prioritas($tahun){

		if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_program_prioritas')){
          	Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_program_prioritas',function(Blueprint $table) use ($schema,$tahun){
               $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('uraibidang')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->text('uraiskpd')->nullable();
                    $table->string('kodeprioritas')->nullable();
                    $table->text('uraiprioritas')->nullable();
            		$table->integer('jenis')->nullable();
                    $table->bigInteger('id_program')->unsigned();
                    $table->bigInteger('transactioncode')->nullable();

            		$table->timestamps();

                    $table->foreign('id_program')
	                  ->references('id')->on($schema.'master_'.$tahun.'_program')
	                  ->onDelete('cascade')->onUpdate('cascade');
	                });
		  	}
      }




	static function kegiatan($tahun){


  		$schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_kegiatan')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_kegiatan',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->integer('status')->default(0);

                    $table->text('kodedata')->unique();
                    $table->bigInteger('id_bidang')->unsigned();
                    $table->bigInteger('id_program')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->bigInteger('id_urusan')->nullable();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->string('kodebidang')->nullable();
                    $table->string('kodeprogram')->nullable();
                    $table->string('kodekegiatan')->nullable();
                    $table->text('uraikegiatan')->nullable();
                    $table->double('pagu',25,3)->default(0);
                    $table->double('pagu_p',25,3)->default(0);
                    $table->double('real_p4',25,3)->nullable();
	                $table->double('pagu_p4',25,3)->nullable();
	                $table->double('real_p3',25,3)->nullable();
	                $table->double('pagu_p3',25,3)->nullable();
	                $table->double('real_p2',25,3)->nullable();
	                $table->double('pagu_p2',25,3)->nullable();
	                $table->double('real_p1',25,3)->nullable();
	                $table->double('pagu_p1',25,3)->nullable();
            		$table->integer('jenis')->nullable();
                	$table->float('progress')->nullable()->default(0);
                	$table->mediumText('capaian')->nullable();
            		$table->integer('kode_lintas_urusan')->nullable();

                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();


		            $table->foreign('id_bidang')
				        ->references('id')->on($schema.'master_'.$tahun.'_bidang')
				        ->onDelete('cascade')->onUpdate('cascade');

				     $table->foreign('id_program')
				        ->references('id')->on($schema.'master_'.$tahun.'_program')
				        ->onDelete('cascade')->onUpdate('cascade');
		              });
         }

	}

	static function kegiatan_indikator($tahun){


  		$schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_kegiatan_indikator')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_kegiatan_indikator',function(Blueprint $table) use ($schema,$tahun){


		                $table->bigIncrements('id');
		            	$table->integer('status')->default(0);
		                $table->text('kodedata')->unique();
		                $table->bigInteger('id_bidang')->unsigned();
		                $table->bigInteger('id_program')->unsigned();
		                $table->bigInteger('id_kegiatan')->unsigned();
		                $table->string('kodepemda',4);
		                $table->integer('tahun');
		            	$table->string('kodebidang')->nullable();
		            	$table->string('kodeskpd')->nullable();
		                $table->string('kodeprogram')->nullable();
		                $table->string('kodekegiatan')->nullable();
		                $table->string('kodeindikator')->nullable();
		                $table->longText('tolokukur')->nullable();
		                $table->longText('satuan')->nullable();
		                $table->longText('target')->nullable();
		                $table->double('pagu',25,3)->default(0);
		                $table->double('pagu_p',25,3)->default(0);
		                $table->longText('target_n1')->nullable();
		                $table->double('pagu_n1',25,3)->default(0);
		            	$table->integer('jenis')->nullable();
                		$table->double('real_p4',25,3)->nullable();
		                $table->double('pagu_p4',25,3)->nullable();
		                $table->double('real_p3',25,3)->nullable();
		                $table->double('pagu_p3',25,3)->nullable();
		                $table->double('real_p2',25,3)->nullable();
		                $table->double('pagu_p2',25,3)->nullable();
		                $table->double('real_p1',25,3)->nullable();
		                $table->double('pagu_p1',25,3)->nullable();
	                	$table->float('progress')->nullable()->default(0);
	                	$table->mediumText('capaian')->nullable();

                        $table->double('target_penyesuaian',25,3)->nullable();
                        $table->boolean('cal')->default(false);
            			$table->integer('kode_lintas_urusan')->nullable();




		                $table->bigInteger('transactioncode')->nullable();
		            	$table->timestamps();


				      	$table->foreign('id_kegiatan')
						      ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
						      ->onDelete('cascade')->onUpdate('cascade');


						$table->foreign('id_bidang')
						      ->references('id')->on($schema.'master_'.$tahun.'_bidang')
						      ->onDelete('cascade')->onUpdate('cascade');


				      	$table->foreign('id_program')
						      ->references('id')->on($schema.'master_'.$tahun.'_program')
						      ->onDelete('cascade')->onUpdate('cascade');

		      });
         }

	}

	static function kegiatan_sumberdana($tahun){


		$schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_kegiatan_sumberdana')){
          	Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_kegiatan_sumberdana',function(Blueprint $table) use ($schema,$tahun){
               $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->string('kodeprogram')->nullable();
                    $table->string('kodekegiatan')->nullable();
                    $table->string('kodesumberdana')->nullable();
                    $table->longText('sumberdana')->nullable();
               		$table->double('pagu',25,3)->default(0);
                  	$table->bigInteger('id_bidang')->unsigned();
                    $table->bigInteger('id_program')->unsigned();
                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();

                    $table->foreign('id_bidang')
				        ->references('id')->on($schema.'master_'.$tahun.'_bidang')
				        ->onDelete('cascade')->onUpdate('cascade');

				     $table->foreign('id_program')
				        ->references('id')->on($schema.'master_'.$tahun.'_program')
				        ->onDelete('cascade')->onUpdate('cascade');

		       		 $table->foreign('id_kegiatan')
				        ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
				        ->onDelete('cascade')->onUpdate('cascade');

	                });
		 }
	}


	static function kegiatan_lokasi($tahun){

		$schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_kegiatan_lokasi')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_kegiatan_lokasi',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->bigInteger('id_bidang')->unsigned();
                    $table->bigInteger('id_program')->unsigned();
                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->string('kodeprogram')->nullable();
                    $table->string('kodekegiatan')->nullable();
                    $table->string('kodelokasi')->nullable();
                    $table->text('lokasi')->nullable();
                    $table->longText('detaillokasi')->nullable();
                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();


		            $table->foreign('id_bidang')
				        ->references('id')->on($schema.'master_'.$tahun.'_bidang')
				        ->onDelete('cascade')->onUpdate('cascade');

				     $table->foreign('id_program')
				        ->references('id')->on($schema.'master_'.$tahun.'_program')
				        ->onDelete('cascade')->onUpdate('cascade');

			         $table->foreign('id_kegiatan')
				        ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
				        ->onDelete('cascade')->onUpdate('cascade');

		           });
          }


	}



	static function kegiatan_prioritas($tahun){

		$schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_kegiatan_prioritas')){
          	Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_kegiatan_prioritas',function(Blueprint $table) use ($schema,$tahun){
               $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('uraibidang')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->text('uraiskpd')->nullable();
                    $table->string('kodeprioritas')->nullable();
                    $table->text('uraiprioritas')->nullable();
            		$table->integer('jenis')->nullable();
                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();

                    $table->foreign('id_kegiatan')
	                  ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
	                  ->onDelete('cascade')->onUpdate('cascade');
	                });
		 }


	}

    static function master_peta_indikator($tahun){
         $schema='rkpd.';
        
         if(!Schema::connection('pgsql')->hasTable($schema.'master_peta_indikator')){
               Schema::connection('pgsql')->create($schema.'master_peta_indikator',function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->text('nama');
                    $table->double('target',25,3)->default(0);
                    $table->string('satuan')->nullable();
                    $table->string('tipe');
                    $table->longText('deskripsi')->nullable();
                    $table->bigInteger('id_urusan')->unsigned();
                    $table->bigInteger('id_sub_urusan')->unsigned();
                    $table->integer('follow')->nullable();
                    $table->timestamps();


                    $table->foreign('id_urusan')
                    ->references('id')->on('public.master_urusan')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_sub_urusan')
                        ->references('id')->on('public.master_sub_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');

                });
                    
         }
    }


    static function peta_indikator_kegiatan($tahun){

        $schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_peta_indikator_kegiatan')){
            Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_peta_indikator_kegiatan',function(Blueprint $table) use ($schema,$tahun){
               		$table->bigIncrements('id');
                    $table->text('kodedata');
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->bigInteger('id_master');
                    $table->unique(['kodepemda','kodedata','id_master','tahun']);


                    $table->foreign('id_master')
                        ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                        ->onDelete('cascade')->onUpdate('cascade');
                });


         }


    }

     static function peta_indikator_program($tahun){

        $schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_peta_indikator_program')){
            Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_peta_indikator_program',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->text('kodedata');
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->bigInteger('id_master');
                    $table->unique(['kodepemda','kodedata','id_master','tahun']);

                   	$table->foreign('id_master')
                        ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
                        ->onDelete('cascade')->onUpdate('cascade');
                });

         }


    }

    static function peta_indikator_sub_kegiatan($tahun){

        $schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_peta_indikator_sub_kegiatan')){
            Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_peta_indikator_sub_kegiatan',function(Blueprint $table) use ($schema,$tahun){
                     $table->bigIncrements('id');
                    $table->text('kodedata');
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->bigInteger('id_master');
                    $table->unique(['kodepemda','kodedata','id_master','tahun']);

                    $table->foreign('id_master')
	                    ->references('id')->on('sink_form.t_'.$tahun.'_indikator')
	                    ->onDelete('cascade')->onUpdate('cascade');
                });

         }


    }

	static function sub_kegiatan($tahun){


  		$schema='rkpd.';


        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_subkegiatan')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_subkegiatan',function(Blueprint $table) use ($schema,$tahun){
                    $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->bigInteger('id_bidang')->unsigned();
                    $table->bigInteger('id_program')->unsigned();
                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->bigInteger('id_urusan')->nullable();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->string('kodebidang')->nullable();
                    $table->string('kodeprogram')->nullable();
                    $table->string('kodekegiatan')->nullable();
                    $table->string('kodesubkegiatan')->nullable();
                    $table->text('uraisubkegiatan')->nullable();
                    $table->double('pagu',25,3)->default(0);
                    $table->double('pagu_p',25,3)->default(0);
            		$table->integer('jenis')->nullable();
                    $table->bigInteger('transactioncode')->nullable();
                    $table->double('real_p4',25,3)->nullable();
	                $table->double('pagu_p4',25,3)->nullable();
	                $table->double('real_p3',25,3)->nullable();
	                $table->double('pagu_p3',25,3)->nullable();
	                $table->double('real_p2',25,3)->nullable();
	                $table->double('pagu_p2',25,3)->nullable();
	                $table->double('real_p1',25,3)->nullable();
	                $table->double('pagu_p1',25,3)->nullable();
                	$table->float('progress')->nullable()->default(0);
                	$table->mediumText('capaian')->nullable();
            		$table->integer('kode_lintas_urusan')->nullable();


            		$table->timestamps();

		            $table->foreign('id_bidang')
				        ->references('id')->on($schema.'master_'.$tahun.'_bidang')
				        ->onDelete('cascade')->onUpdate('cascade');

				     $table->foreign('id_program')
				        ->references('id')->on($schema.'master_'.$tahun.'_program')
				        ->onDelete('cascade')->onUpdate('cascade');
				         $table->foreign('id_kegiatan')
				        ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
				        ->onDelete('cascade')->onUpdate('cascade');
		              });


         }

	}
	static function sub_kegiatan_sumberdana($tahun){


		$schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_subkegiatan_sumberdana')){
          	Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_subkegiatan_sumberdana',function(Blueprint $table) use ($schema,$tahun){
               $table->bigIncrements('id');
                    $table->integer('status')->default(0);
                    $table->text('kodedata')->unique();
                    $table->string('kodepemda',4);
                    $table->integer('tahun');
                    $table->string('kodebidang')->nullable();
                    $table->string('kodeskpd')->nullable();
                    $table->string('kodeprogram')->nullable();
                    $table->string('kodekegiatan')->nullable();
                    $table->string('kodesubkegiatan')->nullable();
                    $table->string('kodesumberdana')->nullable();
                    $table->longText('sumberdana')->nullable();
               		$table->double('pagu',25,3)->default(0);
                  	$table->bigInteger('id_bidang')->unsigned();
                    $table->bigInteger('id_program')->unsigned();
                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->bigInteger('transactioncode')->nullable();
            		$table->timestamps();

                    $table->foreign('id_bidang')
				        ->references('id')->on($schema.'master_'.$tahun.'_bidang')
				        ->onDelete('cascade')->onUpdate('cascade');

				     $table->foreign('id_program')
				        ->references('id')->on($schema.'master_'.$tahun.'_program')
				        ->onDelete('cascade')->onUpdate('cascade');
		       		  $table->foreign('id_kegiatan')
			        ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
			        ->onDelete('cascade')->onUpdate('cascade');

			          $table->foreign('id_sub_kegiatan')
			        ->references('id')->on($schema.'master_'.$tahun.'_subkegiatan')
			        ->onDelete('cascade')->onUpdate('cascade');

	                });
		 }
	}


    static function sub_kegiatan_indikator($tahun){


        $schema='rkpd.';

        if(!Schema::connection('pgsql')->hasTable($schema.'master_'.$tahun.'_subkegiatan_indikator')){
              Schema::connection('pgsql')->create($schema.'master_'.$tahun.'_subkegiatan_indikator',function(Blueprint $table) use ($schema,$tahun){


                        $table->bigIncrements('id');
                        $table->integer('status')->default(0);
                        $table->text('kodedata')->unique();
                        $table->bigInteger('id_bidang')->unsigned();
                        $table->bigInteger('id_program')->unsigned();
                        $table->bigInteger('id_kegiatan')->unsigned();
                        $table->bigInteger('id_sub_kegiatan')->unsigned();

                        $table->string('kodepemda',4);
                        $table->integer('tahun');
                        $table->string('kodebidang')->nullable();
                        $table->string('kodeskpd')->nullable();
                        $table->string('kodeprogram')->nullable();
                        $table->string('kodekegiatan')->nullable();
                        $table->string('kodesubkegiatan')->nullable();
                        $table->string('kodeindikator')->nullable();
                        $table->longText('tolokukur')->nullable();
                        $table->longText('satuan')->nullable();
                    
                        $table->longText('target')->nullable();
                        $table->double('pagu',25,3)->default(0);
                        $table->double('pagu_p',25,3)->default(0);
                        $table->longText('target_n1')->nullable();
                        $table->double('pagu_n1',25,3)->default(0);
                        $table->integer('jenis')->nullable();
                		$table->double('real_p4',25,3)->nullable();
		                $table->double('pagu_p4',25,3)->nullable();
		                $table->double('real_p3',25,3)->nullable();
		                $table->double('pagu_p3',25,3)->nullable();
		                $table->double('real_p2',25,3)->nullable();
		                $table->double('pagu_p2',25,3)->nullable();
		                $table->double('real_p1',25,3)->nullable();
		                $table->double('pagu_p1',25,3)->nullable();
	                	$table->float('progress')->nullable()->default(0);
                		$table->mediumText('capaian')->nullable();
                        $table->double('target_penyesuaian',25,3)->nullable();
                        $table->boolean('cal')->default(false);
            			$table->integer('kode_lintas_urusan')->nullable();



                        $table->bigInteger('transactioncode')->nullable();
                        $table->timestamps();


                        $table->foreign('id_kegiatan')
                              ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                              ->onDelete('cascade')->onUpdate('cascade');

                         $table->foreign('id_sub_kegiatan')
                              ->references('id')->on($schema.'master_'.$tahun.'_subkegiatan')
                              ->onDelete('cascade')->onUpdate('cascade');


                        $table->foreign('id_bidang')
                              ->references('id')->on($schema.'master_'.$tahun.'_bidang')
                              ->onDelete('cascade')->onUpdate('cascade');


                        $table->foreign('id_program')
                              ->references('id')->on($schema.'master_'.$tahun.'_program')
                              ->onDelete('cascade')->onUpdate('cascade');

              });
         }

    }

    public static function view($tahun){
        $schema="rkpd.";

        if(!(DB::table(DB::raw("(select * from information_schema.tables where table_schema='rkpd' and table_name='view_master_".$tahun."_rkpd') as c"))->first())){

            DB::statement("CREATE OR REPLACE VIEW rkpd.view_master_".$tahun."_rkpd
AS
SELECT nx.status,
    nx.index,
    nx.index_p,
    nx.index_pi,
    nx.index_k,
    nx.index_ki,
    nx.kodepemda,
    nx.nama_pemda,
    nx.id_urusan,
    nx.jenis,
    nx.nama_urusan,
    nx.id_sub_urusan,
    nx.nama_sub_urusan,
    nx.kodebidang,
    nx.uraibidang,
    nx.kodeskpd,
    nx.uraiskpd,
    nx.kodeprogram,
    nx.uraiprogram,
    nx.kodekegiatan,
    nx.uraikegiatan,
    nx.pagu_kegiatan,
    nx.kodeindikator,
    nx.indikator,
    nx.target,
    nx.satuan,
    nx.pagu_indikator,
    nx.can_calculate
   FROM ( SELECT min(k.status) AS status,
            concat(min(k.id_program)::text,'.',min(k.id)::text,'.0') AS index,
            min(k.id_program) AS index_p,
            0 AS index_pi,
            min(k.id) AS index_k,
            0 AS index_ki,
            min(k.kodepemda::text) AS kodepemda,
                CASE
                    WHEN length(min(k.kodepemda::text)) > 3 THEN concat(min(d.nama::text), ' - ', ( SELECT p_1.nama
                       FROM master_daerah p_1
                      WHERE p_1.id::text = left(min(k.kodepemda::text), 2)))
                    ELSE min(d.nama::text)
                END AS nama_pemda,
            min(k.id_urusan) AS id_urusan,
            'PROGRAM'::text AS jenis,
            min(u.nama::text) AS nama_urusan,
            min(k.id_sub_urusan) AS id_sub_urusan,
            min(su.nama::text) AS nama_sub_urusan,
            min(k.kodebidang::text) AS kodebidang,
            min(p.uraibidang::text) AS uraibidang,
            min(p.kodeskpd::text) AS kodeskpd,
            min(p.uraiskpd) AS uraiskpd,
            min(k.kodeprogram::text) AS kodeprogram,
            min(p.uraiprogram) AS uraiprogram,
            ''::text AS kodekegiatan,
            ''::text AS uraikegiatan,
            sum(k.pagu) AS pagu_kegiatan,
            ''::character varying AS kodeindikator,
            ''::text AS indikator,
            ''::text AS target,
            ''::text AS satuan,
            NULL::double precision AS pagu_indikator,
            false AS can_calculate
           FROM rkpd.master_".$tahun."_kegiatan k
             LEFT JOIN rkpd.master_".$tahun."_program p ON p.id = k.id_program
             LEFT JOIN master_urusan u ON u.id = k.id_urusan
             LEFT JOIN master_sub_urusan su ON su.id = k.id_sub_urusan
             LEFT JOIN master_daerah d ON d.id::text = k.kodepemda::text
          GROUP BY concat(k.id_program::text ,'|', k.id::text)
        UNION
         SELECT min(k.status) as status,
            concat(min(k.id_program)::text,'.',min(k.id)::text,'.1') AS index,
            min(k.id_program) AS index_p,
            min(pi.id) AS index_pi,
            0 AS index_k,
            0 AS index_ki,
            min(k.kodepemda::text) AS kodepemda,
                CASE
                    WHEN length(min(k.kodepemda::text)) > 3 THEN concat(min(d.nama::text), ' - ', ( SELECT p_1.nama
                       FROM master_daerah p_1
                      WHERE p_1.id::text = left(min(k.kodepemda::text), 2)))
                    ELSE min(d.nama::text)
                END AS nama_pemda,
            min(k.id_urusan) AS id_urusan,
            'CAPAIAN'::text AS jenis,
            min(u.nama::text) AS nama_urusan,
            min(k.id_sub_urusan) AS id_sub_urusan,
            min(su.nama::text) AS nama_sub_urusan,
            min(k.kodebidang::text) AS kodebidang,
            min(p.uraibidang::text) AS uraibidang,
            min(p.kodeskpd::text) AS kodeskpd,
            min(p.uraiskpd) AS uraiskpd,
            min(k.kodeprogram::text) AS kodeprogram,
            min(p.uraiprogram) AS uraiprogram,
            NULL::text AS kodekegiatan,
            NULL::text AS uraikegiatan,
            NULL::double precision AS pagu_kegiatan,
            min(pi.kodeindikator) as kodeindikator,
            min(pi.tolokukur) AS indikator,
            min( pi.target) as target,
            min(pi.satuan) as satuan,
            min(pi.pagu) AS pagu_indikator,
            min(pi.target) ~ '^[0-9\.]+$'::text AS can_calculate
           FROM rkpd.master_".$tahun."_kegiatan k
             LEFT JOIN rkpd.master_".$tahun."_program p ON p.id = k.id_program
             LEFT JOIN master_urusan u ON u.id = k.id_urusan
             LEFT JOIN master_sub_urusan su ON su.id = k.id_sub_urusan
             LEFT JOIN master_daerah d ON d.id::text = k.kodepemda::text
             JOIN rkpd.master_".$tahun."_program_capaian pi ON pi.id_program = k.id_program
             group  by CONCAT(k.id_program::text,'.',k.id::text,'.',pi.id::text)
        UNION
         SELECT k.status,
            concat((k.id_program)::text,'.',(k.id::text),'.2') AS index,
            k.id_program AS index_p,
            0 AS index_pi,
            k.id AS index_k,
            0 AS index_ki,
            k.kodepemda,
                CASE
                    WHEN length(k.kodepemda::text) > 3 THEN concat(d.nama, ' - ', ( SELECT p_1.nama
                       FROM master_daerah p_1
                      WHERE p_1.id::text = left(k.kodepemda::text, 2)))::character varying
                    ELSE d.nama
                END AS nama_pemda,
            k.id_urusan,
            'KEGIATAN'::text AS jenis,
            u.nama AS nama_urusan,
            k.id_sub_urusan,
            su.nama AS nama_sub_urusan,
            k.kodebidang,
            p.uraibidang,
            p.kodeskpd,
            p.uraiskpd,
            k.kodeprogram,
            p.uraiprogram,
            k.kodekegiatan,
            k.uraikegiatan,
            k.pagu AS pagu_kegiatan,
            ''::character varying AS kodeindikator,
            ''::text AS indikator,
            ''::text AS target,
            ''::text AS satuan,
            NULL::double precision AS pagu_indikator,
            false AS can_calculate
           FROM rkpd.master_".$tahun."_kegiatan k
             LEFT JOIN rkpd.master_".$tahun."_program p ON p.id = k.id_program
             LEFT JOIN master_urusan u ON u.id = k.id_urusan
             LEFT JOIN master_sub_urusan su ON su.id = k.id_sub_urusan
             LEFT JOIN master_daerah d ON d.id::text = k.kodepemda::text
              UNION
          SELECT min(k.status) as status,
      concat(min(k.id_program)::text,'.',min(k.id)::text,'.3') AS index,
      min(k.id_program) AS index_p,
      0 AS index_pi,
      min(k.id) AS index_k,
      min(i.id) AS index_ki,
      min(k.kodepemda::text) AS kodepemda,
          CASE
              WHEN length(min(k.kodepemda::text)) > 3 THEN concat(min(d.nama::text), ' - ', ( SELECT p_1.nama
                 FROM master_daerah p_1
                WHERE p_1.id::text = left(min(k.kodepemda::text), 2)))
              ELSE min(d.nama::text)
          END AS nama_pemda,
      min(k.id_urusan) AS id_urusan,
      'INDIKATOR'::text AS jenis,
      min(u.nama::text) AS nama_urusan,
      min(k.id_sub_urusan) AS id_sub_urusan,
      min(su.nama::text) AS nama_sub_urusan,
      min(k.kodebidang::text) AS kodebidang,
      min(p.uraibidang::text) AS uraibidang,
      min(p.kodeskpd::text) AS kodeskpd,
      min(p.uraiskpd) AS uraiskpd,
      min(k.kodeprogram::text) AS kodeprogram,
      min(p.uraiprogram) AS uraiprogram,
      NULL::text AS kodekegiatan,
      NULL::text AS uraikegiatan,
      NULL::double precision AS pagu_kegiatan,
      min(i.kodeindikator) as kodeindikator,
      min(i.tolokukur) AS indikator,
        min( i.target) as target,
      min(i.satuan) as satuan,
      min(i.pagu) AS pagu_indikator,
      min(i.target) ~ '^[0-9\.]+$'::text AS can_calculate
      FROM rkpd.master_".$tahun."_kegiatan k
       LEFT JOIN rkpd.master_".$tahun."_program p ON p.id = k.id_program
       LEFT JOIN master_urusan u ON u.id = k.id_urusan
       LEFT JOIN master_sub_urusan su ON su.id = k.id_sub_urusan
       LEFT JOIN master_daerah d ON d.id::text = k.kodepemda::text
       JOIN rkpd.master_".$tahun."_kegiatan_indikator i ON i.id_kegiatan = k.id
       group  by CONCAT(k.id_program::text,'.',k.id::text,'.',i.id::text)
       ) as nx where id_urusan =3
  ORDER BY nx.kodepemda asc ,nx.index asc, nx.index_p asc, nx.index_k asc; ");

        }


        $data=DB::table('rkpd.master_'.$tahun.'_status_data')->get();

        foreach ($data as $key => $value) {
            DB::table('rkpd.master_'.$tahun."_kegiatan")->where('kodepemda',$value->kodepemda)
            ->update(['status'=>$value->status]);
        }


    }
}