@extends('adminlte::dashboard')
@section('content_header')
    <h1 class="text-center"><b>RKPD {{$pemda->nama}} BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</b></h1>
<hr>

@stop

@section('content')
		<div class="row">

	<form action="{{url()->current()}}" method="get" id="form-f">
			
			<div class="col-md-12">
			<label>URUSAN</label>
			<select class="form-control init-select-2"  name="urusan[]" onchange="$('#form-f').submit()">
				@foreach($list_urusan as $su)
				<option value="{{$su->id}}" {{in_array($su->id,$req->urusan)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
			</div>
	</form>
		</div>
	
		
	<div class="row">
		<div class="col-md-12">
			@php
				$dom_id_rkpd_detail='table-rkpd';
			@endphp
			<div class="box box-solid">
				<div class="box-header">
					<div class="btn-group">
				<button class="btn btn-success btn-sm" onclick="EXPORT_EXCEL('#{{$dom_id_rkpd_detail}}','DATA RKPD  {{$pemda?$pemda->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT EXCEL<i class="fa fa-excel"></i></button>
					<button class="btn btn-primary btn-sm" onclick="EXPORT_PDF('#{{$dom_id_rkpd_detail}}','DATA RKPD  {{$pemda?$pemda->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT PDF<i class="fa fa-pdf"></i></button>
					</div>
				</div>
				<div class="box-body table-responsive " style="max-height: 500px; overflow-y: scroll;">
					@include('sinkronisasi.partial.rkpd_detail',['editable'=>true,'dom_id_rkpd_detail'=>$dom_id_rkpd_detail])
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