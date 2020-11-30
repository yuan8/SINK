
    <h1 class="text-uppercase text-center">{{str_replace('_',' ',$context)}} TAHUN {{$GLOBALS['tahun_access']}}</h1>

    @if((!empty($data_schedule)) and (is_array($data_schedule)))
    	<h5 class="text-uppercase text-center">JADWAL PENGISIAN FORM DESK {{str_replace('_',' ',$context)}} TAHUN {{$GLOBALS['tahun_access']}} DIMULAI PADA {{YT::parse($data_schedule['start'])->format('d F Y')}} - {{YT::parse($data_schedule['end'])->format('d F Y')}}</h5>

    @else
    	<h5 class="text-center">JADWAL PENGISIAN FORM DESK {{str_replace('_',' ',$context)}} TAHUN {{$GLOBALS['tahun_access']}} BELUM TERSEDIA</h5>
    @endif

    <div class="text-center">
    	<img src="{{asset('asset/desk_img.png')}}" style="max-width: 30%;">
    </div>


