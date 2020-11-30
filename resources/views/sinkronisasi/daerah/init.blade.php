@extends('adminlte::dashboard')

@section('content')
<h5 class="text-center"><b>SINKRONISASI DAERAH TAHUN {{$GLOBALS['tahun_access']}}</b></h5>
    <div class="col-md-6 col-md-offset-3">
		<form action="{{route('sink.daerah.init_update',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
			@csrf
			<div class="box box-solid" >
			<div class="box-body">
				<div class="form-group">
					<input type="hidden" >
					<label>PILIH DAERAH</label>
					<select class="form-control" name="kodepemda" id="select_pemda">
						@foreach($data as $d)
							<option value="{{$d->id}}">{{$d->nama_pemda}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="box-footer text-center">
				<button class="btn btn-primary" type="submit">UPDATE</button>
			</div>
		</div>

		</form>
	</div>
@stop

@section('js')
<script type="text/javascript">
	
	$('#select_pemda').select2();
</script>

@stop