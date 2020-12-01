<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SINK\InitRkpdCtrl;
use App\Http\Controllers\SINK\NOMENKLATURCTRL;
use App\Http\Controllers\SINK\InitCtrl;
use DB;

class INIT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sinkronisasi:init {tahun}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $tahun_ac=$this->argument('tahun');

         $tahun_access=[$tahun_ac,$tahun_ac+1];
        foreach ($tahun_access as $key => $tahun) {
            InitCtrl::tahun_access($tahun);
            $this->info("Building  tahun_access {$tahun}");
            InitCtrl::scheduler_desk($tahun);
            $this->info("Building  scheduler_desk {$tahun}");

            InitCtrl::sumber_indikator($tahun);
            $this->info("Building  sumber_indikator {$tahun}");

            InitCtrl::kebijakan($tahun);
            $this->info("Building  kebijakan {$tahun}");

            InitCtrl::rpjmn($tahun);
            $this->info("Building  rpjmn {$tahun}");

            InitCtrl::rkp($tahun);
            $this->info("Building  rkp {$tahun}");

            InitCtrl::kewenangan($tahun);
            $this->info("Building  kewenangan {$tahun}");

            InitCtrl::indikator($tahun);
            $this->info("Building  indikator {$tahun}");

            InitCtrl::kewenangan_bridge($tahun);
            $this->info("Building  kewenangan_bridge {$tahun}");

            InitCtrl::permasalahan($tahun);
            $this->info("Building  permasalahan {$tahun}");


            InitCtrl::nomenklatur($tahun);
            $this->info("Building  nomenklatur {$tahun}");

            InitCtrl::rekomendasi($tahun);
            $this->info("Building  rekomendasi {$tahun}");

            InitCtrl::rekomendasi_indikator($tahun);
            $this->info("Building  rekomendasi_indikator {$tahun}");

            InitCtrl::bridge_indikator_pusat($tahun);
            $this->info("Building  bridge_indikator_pusat {$tahun}");


            InitRkpdCtrl::status($tahun);
            $this->info("Building  status rkpd {$tahun}");

        
            InitRkpdCtrl::bidang($tahun);
            $this->info("Building  bidang rkpd {$tahun}");

            InitRkpdCtrl::program($tahun);

            $this->info("Building  program rkpd {$tahun}");

            InitRkpdCtrl::program_capaian($tahun);
            $this->info("Building  program_capaian rkpd {$tahun}");


            InitRkpdCtrl::kegiatan($tahun);
            $this->info("Building  program_capaian rkpd {$tahun}");

            InitRkpdCtrl::kegiatan_indikator($tahun);
            $this->info("Building  kegiatan_indikator rkpd {$tahun}");

            InitRkpdCtrl::kegiatan_sumberdana($tahun);
            $this->info("Building  kegiatan_sumberdana rkpd {$tahun}");


            InitRkpdCtrl::sub_kegiatan($tahun);
            $this->info("Building  sub_kegiatan rkpd {$tahun}");

            InitRkpdCtrl::sub_kegiatan_indikator($tahun);
            $this->info("Building  sub_kegiatan_indikator rkpd {$tahun}");

            InitRkpdCtrl::sub_kegiatan_sumberdana($tahun);
            $this->info("Building  sub_kegiatan_sumberdana rkpd {$tahun}");

            InitRkpdCtrl::view($tahun);
            $this->info("Building  view rkpd {$tahun}");

            // InitRkpdCtrl::master_peta_indikator($tahun);
            InitRkpdCtrl::peta_indikator_kegiatan($tahun);
            $this->info("Building  peta_indikator_kegiatan rkpd {$tahun}");

            InitRkpdCtrl::peta_indikator_program($tahun);
            $this->info("Building  peta_indikator_program rkpd {$tahun}");

            InitRkpdCtrl::peta_indikator_sub_kegiatan($tahun);
            $this->info("Building  peta_indikator_sub_kegiatan rkpd {$tahun}");

            InitRkpdCtrl::permasalahan_rkpd($tahun);
            $this->info("Building  permasalahan_rkpd rkpd {$tahun}");

            InitCtrl::dukungan_pusat_indikator($tahun);
            $this->info("Building  dukungan_pusat_indikator {$tahun}");

            InitCtrl::nested_indikator($tahun);
            $this->info("Building  nested_indikator {$tahun}");

            InitCtrl::nspk_rekomendasi($tahun);
            $this->info("Building  nspk_rekomendasi {$tahun}");

            NOMENKLATURCTRL::init($tahun);
            $this->info("Building  NOMENKLATURCTRL {$tahun}");


          DB::table('sink_form.t_'.$tahun.'_nomenklatur')->where('id_urusan',2)->update([
              'id_urusan'=>3
          ]);
            $this->info("Building  done {$tahun} --------------------------------------");

                 
         } 
    }
}
