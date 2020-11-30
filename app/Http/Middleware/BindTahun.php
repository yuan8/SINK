<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class BindTahun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tahun=$request->route('tahun');

        if(!isset($GLOBALS['list_tahun_access'])){
            $GLOBALS['list_tahun_access']=(DB::table('sink_form.tahun_access')->select('tahun')->get()->pluck('tahun'));
        }


        if($tahun!=2020){
             if(!in_array($tahun,$GLOBALS['list_tahun_access']->toArray())){
                return redirect()->route('index',['tahun'=>2020]);
                
            }
        }

        if((empty($tahun)) OR (!is_numeric($tahun))){
            return redirect()->route('index',['tahun'=>2020]);
        }else{
            $GLOBALS['tahun_access']=$tahun;
            return $next($request);
        }
    }
}
