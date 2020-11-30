<?php

namespace App\Http\Middleware;

use Closure;
use YDB;
use Auth;
class PemdaMiddleware
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
        $user=Auth::User();

        $tahun=$request->route('tahun');
        $kodepemda=$request->route('kodepemda');
        if(empty($request->route('menu_context')) ){
            if($user->role==3){
               return redirect()->route('sink.daerah.index',['tahun'=>$tahun,'kodepemda'=>$user->kodepemda,'menu_context'=>'D']);
            }else{
                return redirect()->route('sink.daerah.index',['tahun'=>$tahun,'kodepemda'=>$kodepemda,'menu_context'=>'D']);
            }
        }

        $menu_context=$request->route('menu_context')??'P';


        $GLOBALS['menu_access']=$menu_context;
        if((empty($kodepemda)) OR (!is_numeric($kodepemda))){
            return redirect()->route('sink.daerah.init',['tahun'=>$tahun]);
        }else{
            $daerah=YDB::query("select *,(case when length(d.id)<3 then nama else (select concat(d.nama,' - ',p.nama) from public.master_daerah as p where p.id=left(d.id::text,2))end) as nama_pemda from public.master_daerah as d where d.id='".$kodepemda."' limit 1")->first();

            if($daerah){
                if($user->role==3){
                    if(empty($user->kodepemda)){
                        Auth::logout();
                        return $next($request);
                    }

                    if(($daerah->id==$user->kodepemda) and (!empty($user->kodepemda))){
                         $GLOBALS['pemda_access']=$daerah;
                        return $next($request);
                    }else{
                        return redirect()->route('sink.daerah.index',['tahun'=>$tahun,'kodepemda'=>$user->kodepemda,'menu_context'=>'D']);
                    }

                }else{
                    $GLOBALS['pemda_access']=$daerah;
                    return $next($request);
                }

               
            }else{
                return redirect()->route('sink.daerah.init',['tahun'=>$tahun]);
            }

          
        }
    }
}
