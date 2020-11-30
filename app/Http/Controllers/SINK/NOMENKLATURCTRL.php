<?php

namespace App\Http\Controllers\SINK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Storage;
use DB;
class NOMENKLATURCTRL extends Controller
{
    //


	static function jenis($tahun=2020,$d,$id_u=null,$prov=false){
		$jenis=null;
		$kodeP=null;
		$kodeK=null;
		$kodeU=null;
		$kodeB=null;

		if(!empty($d[5])){
			$jenis='SUB KEGIATAN';
			$kode=$d[1].'.'.$d[2].'.'.$d[3].'.'.$d[4].'.'.$d[5];
			$kodeK=$d[1].'.'.$d[2].'.'.$d[3].'.'.$d[4];
			$kodeP=$d[1].'.'.$d[2].'.'.$d[3];
			$kodeB=$d[1].'.'.$d[2];
			$kodeU=$d[1];
		}else if(!empty($d[4])){
			$jenis='KEGIATAN';
			$kode=$d[1].'.'.$d[2].'.'.$d[3].'.'.$d[4];
			$kodeP=$d[1].'.'.$d[2].'.'.$d[3];
			$kodeB=$d[1].'.'.$d[2];
			$kodeU=$d[1];
		}else if(!empty($d[3])){
			$jenis='PROGRAM';
			$kode=$d[1].'.'.$d[2].'.'.$d[3];
			$kodeB=$d[1].'.'.$d[2];
			$kodeU=$d[1];
		}else if(!empty($d[2])){
			$jenis='BIDANG URUSAN';
			$kode=$d[1].'.'.$d[2];
			$kodeB=$d[1].'.'.$d[2];
			$kodeU=$d[1];
		}else if(!empty($d[1])){
			$jenis='URUSAN';
			$kode=$d[1];			
		}else{

		}


		if(!empty($d[6])){
			$uraian=$d[6];
		}else{
			$uraian='NON '.$jenis.' URUSAN';
		}

		if(!empty($jenis)){
			if(!empty($d[6])){
				$uraian=$d[6];
			}else{
				$uraian='NON '.$jenis.' URUSAN';
			}

			return array(
				'provinsi'=>$prov,
				'id_urusan'=>($id_u??null),
				'kode'=>$kode,
				'jenis'=>$jenis,
				'uraian'=>$uraian,
				'tahun'=>$tahun,
				'kode_urusan'=>$kodeU,
				'kode_bidang'=>$kodeB,
				'kode_program'=>$kodeP,
				'kode_kegiatan'=>$kodeK,

			);
		}else{
			return false;
		}
	}

   public static function provinsi($tahun){
   	
   	
   
   	$json=[];
   	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public/init/2020/nomen_provinsi.Xlsx'));
	$sheetCount = $spreadsheet->getSheetCount(); 
	for ($i = 0; $i < $sheetCount; $i++){
		$approve=FALSE;
		preg_match('#\((.*?)\)#',$spreadsheet->getSheetNames()[$i],$match);
		if(isset($match[1])){
			$id_urusan=$match[1];
		}else{
			$id_urusan=null;
		}

		$sheet = $spreadsheet->getSheet($i);
		$data=$sheet->toArray();
		foreach ($data as $key => $d) {
			if($approve){
				$dtt=static::jenis($tahun,$d,$id_urusan,true);
				if($dtt){
					$json[$i][]=$dtt;
					DB::table('sink_form.t_'.$tahun.'_nomenklatur')->insertOrIgnore($dtt);
				}
			}
			if($d[1]=='URUSAN'){
				$approve=TRUE;
			}
		
		}
		
	} 
	Storage::put('/public/init/'.$tahun.'/nomen_provinsi.json',json_encode($json));


	

   }


   public static function kab($tahun){
   	

   
   	$json=[];
   	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public/init/2020/nomen_kab-X.Xlsx'));
	$sheetCount = $spreadsheet->getSheetCount(); 
	for ($i = 0; $i < $sheetCount; $i++){
		$approve=FALSE;
		preg_match('#\((.*?)\)#',$spreadsheet->getSheetNames()[$i],$match);
		if(isset($match[1])){
			$id_urusan=$match[1];
		}else{
			$id_urusan=null;
		}

		$sheet = $spreadsheet->getSheet($i);
		$data=$sheet->toArray();
		foreach ($data as $key => $d) {
			if($approve){
				$dtt=static::jenis($tahun,$d,$id_urusan,false);
				if($dtt){
					$json[$i][]=$dtt;
					DB::table('sink_form.t_'.$tahun.'_nomenklatur')->insertOrIgnore($dtt);
				}
			}
			if($d[1]=='URUSAN'){
				$approve=TRUE;
			}
		
		}
		
	} 

	Storage::put('/public/init/'.$tahun.'/nomen_kab.json',json_encode($json));

	

   }


   public static function init($tahun){
   	static::provinsi($tahun);
   	static::kab($tahun);

   }
}
