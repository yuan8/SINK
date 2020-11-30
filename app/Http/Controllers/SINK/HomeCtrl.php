<?php

namespace App\Http\Controllers\SINK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class HomeCtrl extends Controller
{
    //

    public function index($tahun){
    	
    	return view('sinkronisasi.index');
    }


    public function tahun_acces($tahun,Request $request){

    	return view('sinkronisasi.form_ubah_tahun')->with([
    		'link_back'=>str_replace('/'.$tahun, 'xxxxx',$request->link_back),
    		'tahun'=>$tahun,
            'list_tahun'=>$GLOBALS['list_tahun_access']
    	]);
    }


     public function ubah_urusan($tahun,Request $request){
         $GLOBALS['list_tahun_access']=(DB::table('sink_form.tahun_access')->select('tahun')->get()->pluck('tahun'));
        if(Auth::check()){

            $user=Auth::User();
            if(in_array($user->role,[1,3])){
                 foreach (session('list_urusan') as $key => $u) {

                    if($u->id==$request->id_urusan){
                        session(['main_urusan'=>$u]);
                        return redirect($request->back_link)->with('change_urusan',$u->id);
                    }
                }
            }
           

            return back();
        }
        return back();
    }


     public function ubah_tahun_access($tahun,Request $request){
        $GLOBALS['list_tahun_access']=(DB::table('sink_form.tahun_access')->select('tahun')->get()->pluck('tahun'));

         
     	$link_back=str_replace('xxxxx', '/'.$request->tahun, $request->link_back);

     	return redirect($link_back);

    }
}
