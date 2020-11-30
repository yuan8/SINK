@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')
@section('content_header')
    <h1 class="text-center">SINKRONISASI DAERAH BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>

    
@stop

@section('content')
<div class="text-center">
	<img src="{{asset('logo.png')}}" style="width: 15%">
	
	<div style="margin-top: 10px;" class="text-center">
		<h4><b>DITJEN BINA PEMBANGUNAN DAERAH SUPD II</b></h4>
		<h5><b>KEMENTERIAN DALAM NEGERI</b></h5>

		<p class="text-center"><b>{{$GLOBALS['pemda_access']->nama_pemda}}</b></p>
	</div>

</div>

@stop