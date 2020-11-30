@extends('adminlte::dashboard')
@section('content_header')
    <h1 class="text-center">RKPD {{$pemda->nama}} BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>
<hr>

@stop

@section('content')
<div class="container-fluid" style="margin-bottom: 10px;">
	<form action="{{url()->current()}}" method="get" id="form-f">
			
		<div class="col-md-12">
			<label>URUSAN</label>
			<select class="form-control init-select-2" multiple="" name="urusan[]" onchange="$('#form-f').submit()">
				@foreach($list_urusan as $su)
				<option value="{{$su->id}}" {{in_array($su->id,$req->urusan)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
		</div>
	</form>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body table-responsive " style="max-height: 500px; overflow-y: scroll;">
					@include('sinkronisasi.partial.rkpd_detail',['editable'=>true])
				</div>
			</div>
		</div>
	</div>

@stop

@section('js')
<script type="text/javascript">
	
	$('.init-select-2').select2();

	function showform(url){
		$.get(url,function(res){
			$('#modal_sm .modal-content').html(res);
			$('#modal_sm').modal();
		});
	}

</script>
@stop