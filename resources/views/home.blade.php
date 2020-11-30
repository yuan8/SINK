@extends('adminlte::dashboard')

@section('content')
    <div class=" bg-info" style=" margin-bottom:20px;min-height: 25px; width:100%">
    	<marquee behavior="scroll" direction="left">@foreach($scheduler_desk as $sc)
    | PEMETAAN {{str_replace('_',' ',$sc->jenis)}} ({{YT::parse($sc->start)->format('d M Y').' - '.YT::parse($sc->end)->format('d M Y')}})
    @endforeach
</marquee>
    </div>

    <div class="row" id="info-box">
    	
    </div>
@stop


@section('js')
<script type="text/javascript">
	
	$.post('{{route('d.box.rkpd',['tahun'=>$GLOBALS['tahun_access']])}}',function(res){
		$('#info-box').append(res);
	});

	$.post('{{route('d.box.kebijakan',['tahun'=>$GLOBALS['tahun_access']])}}',function(res){
		$('#info-box').append(res);
	});
	$.post('{{route('d.box.permasalahan',['tahun'=>$GLOBALS['tahun_access']])}}',function(res){
		$('#info-box').append(res);
	});
	$.post('{{route('d.box.rekomendasi',['tahun'=>$GLOBALS['tahun_access']])}}',function(res){
		$('#info-box').append(res);
	});
</script>
@stop