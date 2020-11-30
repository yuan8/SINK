<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use YT;
class DeskProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
     public static function kodeCreate($kode){
        
        for($i=strlen($kode."");$i<5;$i++){
            $kode='0'.$kode;
        }
        return $kode;
    }


    static function getInfo($context,$tahun=2020){

        $data = array(
            'context' =>$context ,
            'schedule'=>(array)DB::connection('sink_form')
                        ->table('sink_form.t_'.$tahun.'_scheduler_desk')
                        ->where([['jenis','=',$context]])->first(),
            'active'=>static::schedule_active($context,$tahun),
        );

         $GLOBALS['schedule_desk'][$context]=$data['schedule'];

        if(!$data['active']){
            if(isset($data['schedule']['end'])){
                if(YT::parse($data['schedule']['end'])->gt(YT::now())){
                     $data['view_hasil']=view('block.view_hasil')->with(['data_schedule'=>$data['schedule'],'context'=>$context])->render();
                }else{
                    $data['view_block']=view('block.schedule_unactive')->with(['data_schedule'=>$data['schedule'],'context'=>$context])->render();
                }
                
            }else{
                  $data['view_block']=view('block.schedule_unactive')->with(['data_schedule'=>$data['schedule'],'context'=>$context])->render();
            }


          
        }

        return $data;

    }

    static function schedule_active($context,$tahun){
        $accept=null;
        $now=YT::now();
        $accept=(array)DB::connection('sink_form')->table('sink_form.t_'.$tahun.'_scheduler_desk')->where([
            ['jenis','=',$context],
            ['start','<=',$now],
            ['end','>=',$now],
        ])
        ->first();

        if(!empty($accept)){
            $accept=true;
        }else{
            $accept=false;
        }

        return $accept;

    }
}
