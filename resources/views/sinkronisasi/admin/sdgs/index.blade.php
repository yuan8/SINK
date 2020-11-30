@extends('adminlte::admin')


@section('content_header')
    <h1 class="">SDGS TAHUN {{$GLOBALS['tahun_access']}}</h1>
    <div class="btn-group" style="margin-top: 40px!important">
		<button class="btn btn-primary" id="btn-tambah-mandat" onclick="showForm('{{route('sink.admin.sdgs.add',['tahun'=>$GLOBALS['tahun_access']])}}')">TAMBAH TUJUAN GLOBAL</button>
	</div>
    
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body table-responsive">
				<table class="table table-bordered" id="treetable-init">
					<thead>
						
						<tr>
							<th style="width: 200px;">AKSI</th>
							<th style="width: 150px;">JENIS</th>
							<th>URAIAN</th>
							<th>PELAKSANA</th>

							

						</tr>
					</thead>
					<tbody>
						@foreach($data as $d)
							<tr data-tt-id="sdgs_{{$d->id}}" >
								<td>
									<div class="btn-group">
											<button class="btn  btn-xs btn-danger" onclick="showForm('')"><i class="fa fa-trash"></i></button>
											<button class="btn  btn-xs btn-warning" onclick="showForm('')" ><i class="fa fa-pen"></i></button>
											<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.admin.sdgs.add',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" ><i class="fa fa-plus"></i> SASARAN GLOBAL</button>
										</div>

								</td>
								<td>{{$d->jenis}}</td>
								<td>{!!nl2br($d->uraian)!!}</td>
								<td></td>


							</tr>
								@foreach($d->child as $s)
								<tr data-tt-id="sdgs_{{$s->id}}" data-tt-parent-id="sdgs_{{$s->id_parent}}">
									<td>
										<div class="btn-group">
												<button class="btn  btn-xs btn-danger" onclick="showForm('')"><i class="fa fa-trash"></i></button>
												<button class="btn  btn-xs btn-warning" onclick="showForm('')" ><i class="fa fa-pen"></i></button>
												<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.admin.sdgs.add',['tahun'=>$GLOBALS['tahun_access'],'id'=>$s->id])}}')" ><i class="fa fa-plus"></i> SASARAN NASIONAL</button>
											</div>

									</td>
									<td>{{$s->jenis}}</td>
									<td>{!!nl2br($s->uraian)!!}</td>
									<td></td>


								</tr>
								@foreach($s->child as $n)
									<tr data-tt-id="sdgs_{{$n->id}}" data-tt-parent-id="sdgs_{{$n->id_parent}}">
										<td>
											<div class="btn-group">
													<button class="btn  btn-xs btn-danger" onclick="showForm('')"><i class="fa fa-trash"></i></button>
													<button class="btn  btn-xs btn-warning" onclick="showForm('')" ><i class="fa fa-pen"></i></button>
													
												</div>

										</td>
										<td>{{$n->jenis}}</td>
										<td>{!!nl2br($n->uraian)!!}</td>
										<td>{!!nl2br($n->pelaksana)!!}</td>



									</tr>
								@endforeach
							@endforeach
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
	
	$('#treetable-init').treetable({ expandable: true,column:1,initialState:'expanded' });


</script>
@stop