<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperViewProvider extends ServiceProvider
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

    static function status_rkpd($status){
      switch ($status) {
        case 0:
        $status='BELUM TERDAPAT STATUS';
          break;
        case 1:
        $status='PERSIAPAN';
          break;
        case 2:
        $status='RKPD RANWAL';
          break;
        case 3:
          $status='RKPD RANCANGAN';
          break;
        case 4:
        $status='RKPD AHIR';
          break;
        case 5:
        $status='RKPD FINAL';
          break;
        default:
          // code...
          break;
      }
      return $status;
    }

   
    /**
     * Bootstrap services.
     *
     * @return void
     */


    public static function percertase_color($value){
        $color='black';
        $value=$value;
        if($value==0){
        $color='black';

        }else if( $value<=20){
                $color='red';
                # code...
                }
        else if( $value<=40){
            $color='orange';
            # code...
         }
         else if( $value<=60){
            $color='yellow';
            # code...
            }
         else if( $value<=80){
            $color='green';
            # code...
            }
         else if( $value<=1000){
            $color='#45ff23';
            # code...
            }
        return $color;
    }

    static function list_id_urusan(){
        return [3,4,15,16,20,21,25];
    }
    static function rpjmn_now($tahun){
        $init_tahun=2020;
        $last_tahun=$init_tahun+4;
        while (!(($tahun>=$init_tahun)and($tahun<=$last_tahun))) {
            $init_tahun=$last_tahun+1;
            $last_tahun=$init_tahun+4;
        }

        return ('('.$init_tahun.'-'.$last_tahun.')');
    }

    static function rkpd_nes($d)
    {
         $map=['parent'=>'0','skpd'=>'','bidang'=>'','id'=>'0','kode'=>'','jenis'=>'','uraian'=>'','target'=>'','satuan'=>'','pagu'=>0,'kodedata'=>null];
        switch ($d->jenis) {
            case 'PROGRAM':
                $map['parent']='BIDANG_';
                $map['id']='PROGRAM_'.$d->id;
                $map['kode']=$d->kodeprogram;
                $map['uraian']=$d->uraiprogram;
                $map['pagu']=$d->pagu;
                $map['jenis']='PROGRAM';
                $map['bidang']=$d->uraibidang;
                $map['skpd']=$d->uraiskpd;
                $map['kodedata']=$d->kodedata;
                # code...
                break;
            case 'CAPAIAN':
                 $map['parent']='PROGRAM_'.$d->id_program;
                 $map['id']='CAPAIAN_'.$d->id;
                $map['kode']=$d->kodeindikator;
                $map['uraian']=$d->tolokukur;
                $map['target']=$d->target;
                $map['satuan']=$d->satuan;
                $map['jenis']='OUTCOME';
                $map['pagu']=$d->pagu;
                $map['kodedata']=$d->kodedata;

                # code...
                break;
            case 'KEGIATAN':
                $map['parent']='PROGRAM_'.$d->id_program;
                $map['id']='KEGIATAN_'.$d->id;
                $map['kode']=$d->kodekegiatan;
                $map['uraian']=$d->uraikegiatan;
                $map['pagu']=$d->pagu;
                $map['jenis']='KEGIATAN';
                $map['kodedata']=$d->kodedata;


                # code...
                break;
            
            case 'INDIKATOR':
                 $map['parent']='KEGIATAN_'.$d->id_kegiatan;
                 $map['id']='INDIKATOR_'.$d->id;
                $map['kode']=$d->kodeindikator;
                $map['uraian']=$d->tolokukur;
                $map['target']=$d->target;
                $map['satuan']=$d->satuan;
                $map['jenis']='OUTPUT';
                $map['pagu']=$d->pagu;
                $map['kodedata']=$d->kodedata;

                # code...
                break;
            
            default:
                # code...
                break;
        }

        return $map;
        //
    }

    public static function c_icon($d){
        $icon='<i class="fa fa-circle text-warning"></i>';
        switch ($d) {
            case 1:
                # code...
            $icon='<i class="fa fa-circle text-primary"></i>';
                break;
            case 2:
            $icon='<i class="fa fa-circle text-success"></i>';
                # code...
                break;
            case 3:
                # code...
             $icon='<i class="fa fa-circle text-warning"></i>';

                break;
            
            default:
                # code...
                break;
        }
        return $icon;
    }
    public static function reg_d_penilaian($d){
        $icon='BELUM DINILAI';
        switch ($d) {
            case 0:
                # code...
            $icon='BELUM DINILAI';
                break;
            case 1:
            $icon='<i class="fa fa-check text-success"></i> SESUAI';
                # code...
                break;
            case 2:
                # code...
             $icon='<i class="fa fa-times text-danger"></i> BELUM SESUAI';

                break;
            
            default:
                # code...
                break;
        }
        return $icon;
    }
}
