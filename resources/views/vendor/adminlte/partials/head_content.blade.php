@if(isset($GLOBALS['schedule_desk']))
    @php
       $scForm= array_values($GLOBALS['schedule_desk'])[0];
    @endphp
    <div class="row bg-navy" >
        <div class="col-md-12">
            <div class="col-md-6">
                 <p class="text-capitalize"  style="margin-top: 5px; font-size:14px; margin-bottom: 0px;">
                 @isset($back_link_pusat)
                  <a href="{{$back_link_pusat}}" style="font-size:14px; color: yellow;" ><i class="fa fa-2 fa-arrow-circle-left"></i></a>
                 @endisset
                    @isset($back_link_daerah)
                     <a href="{{$back_link_daerah}}" style="font-size:14px; color: yellow;" ><i class="fa fa-2 fa-arrow-circle-left"></i></a>
                 @endisset   
               
                 {{(null!=session('main_urusan')?session('main_urusan')->nama:'')}}  ({{isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:''}})
                
                   <small> {{isset($GLOBALS['pemda_access'])?' - '. $GLOBALS['pemda_access']->nama_pemda:''}}</small>

                
             </p>
            </div>
            <div class="col-md-6 " style="">
                <p  class="text-right" style="margin-top: 5px;" >Jadwal Pengisian {{YT::parse($scForm['start'])->format('d F Y')}} - {{YT::parse($scForm['end'])->format('d F Y')}}</p>
            </div>
        </div>
    </div>
    
@elseif(null!==session('main_urusan'))
<div class="row bg-navy" >
        <div class="col-md-12">
            <div class="col-md-6 ">
                 <p  class="text-capitalize" style="font-size:14px; margin-bottom: 0px;">
                 @isset($back_link_pusat)
                  <a href="{{$back_link_pusat}}" style="font-size:14px; color: yellow;" ><i class="fa fa-2 fa-arrow-circle-left"></i></a>
                 @endisset
                    @isset($back_link_daerah)
                     <a href="{{$back_link_daerah}}" style="font-size:14px; color: yellow;" ><i class="fa fa-2 fa-arrow-circle-left"></i></a>
                 @endisset   
               
                {{(null!=session('main_urusan')?session('main_urusan')->nama:'')}}  ({{isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:''}}) 
                  <small> {{isset($GLOBALS['pemda_access'])?' - '. $GLOBALS['pemda_access']->nama_pemda:''}}</small>
            </p>
            </div>
            
        </div>
</div>


@endif