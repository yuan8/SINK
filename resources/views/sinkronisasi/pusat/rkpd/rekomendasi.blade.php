@extends('adminlte::pusat')


    
@section('content_header')
    <h1>REKOMENDASI RKPD PEMDA - PEMETAAN TAHUN {{$GLOBALS['tahun_access']}}</h1>
   
    
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body table-responsive">
				<table class="table table-bordered" id="datatable-init">
					<thead>
						
						<tr>
							<th>AKSI</th>
							<th>KODEPEMDA</th>
							<th style="min-width: 230px;">NAMA PEMDA</th>
							<th>JUMLAH PERMASALAHAN</th>
							<th>JUMLAH PROGRAM</th>
							<th>JUMLAH KEGIATAN </th>




						</tr>
					</thead>
					<tbody>
						@foreach($data as $d)
							<tr class="{{($d->jumlah_kegiatan==0)?'bg-warning':''}}">
								<td>
									<div class="btn-group">
										<a href="{{route('sink.daerah.rekomendasi.index',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>$d->kodepemda,'menu_context'=>'P' ])}}" class="btn btn-xs btn-primary">DETAIL</a>
									</div>
								</td>
								<td>{{$d->kodepemda}}</td>
								<td>{{$d->nama_pemda}}</td>
								<td>{{number_format($d->jumlah_masalah)}} PERMASALAHAN</td>

								<td>{{number_format($d->jumlah_program)}} PROGRAM</td>
								<td>{{number_format($d->jumlah_kegiatan)}} KEGIATAN</td>



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
	
	$('#datatable-init').dataTable({sort:false});

	function showform(url){
		$.get(url,function(res){
			$('#modal_lg .modal-content').html(res);
			$('#modal_lg').modal();
		});
	}

</script>
@stop