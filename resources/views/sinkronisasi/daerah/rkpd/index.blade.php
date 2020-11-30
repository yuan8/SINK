@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')
@section('content_header')
    <h1 class="">RKPD {{$GLOBALS['pemda_access']->nama_pemda}} BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>

    
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body table-responsive " style="max-height: 500px; overflow-y: scroll;">
					@include('sinkronisasi.partial.rkpd_detail')
				</div>
			</div>
		</div>
	</div>

@stop

@section('js')
<script type="text/javascript">
	
	

	function showform(url){
		$.get(url,function(res){
			$('#modal_sm .modal-content').html(res);
			$('#modal_sm').modal();
		});
	}

</script>
@stop