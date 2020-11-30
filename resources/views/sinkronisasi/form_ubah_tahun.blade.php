@extends('adminlte::dashboard')


@section('content_header')
    
@stop


@section('content')
	<div class="col-md-6 col-md-offset-3">
		<form action="" method="post">
			@csrf
			<div class="box box-solid" >
			<div class="box-body">
				<div class="form-group">
					<input type="hidden" name="link_back" value="{{$link_back}}">
					<label>TAHUN AKSES DATA</label>
					<select class="form-control" name="tahun">
						@foreach($GLOBALS['list_tahun_access'] as $t)
						
							<option value="{{$t}}" {{$t==$GLOBALS['tahun_access']?'selected':''}}>{{$t}}</option>
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