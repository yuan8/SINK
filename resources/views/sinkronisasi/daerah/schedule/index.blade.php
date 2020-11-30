
@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')

@section('content_header')

    <h1>SCHEDULE DESK SINKRONISASI TAHUN {{$GLOBALS['tahun_access']}}</h1>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body table-responsive">
				<table class="table table-bordered" id="treetable-init">
					<thead>
						<tr>
							<th>DESK</th>
							<th>MULAI</th>

							<th>BERAHIR</th>
							<th>KETERANGAN</th>
							

						</tr>
					</thead>
					<tbody>
						@foreach($data as $d)
							<tr>
								<td>
									DESK {{str_replace('_',' ',$d->jenis)}}
								</td>
								<td>
									{{YT::parse($d->start)->format('d F Y')}}
								</td>
								<td>
									{{YT::parse($d->end)->format('d F Y')}}
								</td>
								<td>
									
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
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