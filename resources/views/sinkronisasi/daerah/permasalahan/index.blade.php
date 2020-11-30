@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')
@section('content_header')

    <h1 class="">PERMASALAHAN {{$GLOBALS['pemda_access']->nama_pemda}} BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>
    <div class="btn-group" style="margin-top: 10px;">
  		<button class="btn btn-primary" onclick="showForm('{{route('sink.daerah.permasalahan.form.add',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access']])}}')">TAMBAH MASALAH POKOK</button>
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
							<th>SUB URUSAN</th>
							<th style="min-width: 150px;">JENIS</th>
							<th style="min-width: 100px;">AKSI</th>
							<th style="min-width: 100px;">KETEGORI</th>
							<th style="min-width: 100px;">SUMBER DATA</th>

							<th style="min-width: 230px;">URAIAN</th>
							<th>TERIMPLENTASI PADA REKOMENDASI RKPD</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $mp)

							<tr data-tt-id="PMD_{{$mp->id}}">
								<td>{{$mp->nama_sub_urusan}}</td>
								<td>{{$mp->jenis}}</td>
							

								<td>
									<div class="btn-group">
										<button class="btn  btn-xs btn-danger" onclick="showForm('{{route('sink.daerah.permasalahan.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$mp->id])}}')"><i class="fa fa-trash"></i></button>
										<button class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.daerah.permasalahan.form.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$mp->id])}}')"><i class="fa fa-pen"></i></button>
										<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.daerah.permasalahan.form.add',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$mp->id])}}')"><i class="fa fa-plus" ></i> MASALAH</button>
									</div>
								</td>
								<td>{{$mp->kategori}}</td>
								<td>{{$mp->uraian_sumber_data}}</td>
								<td>{{$mp->uraian}}</td>
								<td>{{$mp->implement?'IMPLEMENTED':'-'}}</td>
							</tr>
							@foreach($mp->ms as $ms)
								<tr data-tt-id="PMD_{{$ms->id}}" data-tt-parent-id="PMD_{{$ms->id_parent}}">
									<td></td>
									<td>{{$ms->jenis}}</td>
									<td>
										<div class="btn-group">
											<button class="btn  btn-xs btn-danger" onclick="showForm('{{route('sink.daerah.permasalahan.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$ms->id])}}')"><i class="fa fa-trash"></i></button>
										<button class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.daerah.permasalahan.form.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$ms->id])}}')"><i class="fa fa-pen"></i></button>
											<button class="btn  btn-xs btn-success"  onclick="showForm('{{route('sink.daerah.permasalahan.form.add',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$ms->id])}}')"><i class="fa fa-plus"></i> AKAR MASALAH</button>
										</div>
									</td>
									<td>{{$ms->kategori}}</td>
								<td>{{$ms->uraian_sumber_data}}</td>
								<td>{{$ms->uraian}}</td>
								<td>{{$ms->implement?'IMPLEMENTED':'-'}}</td>
								</tr>

								@foreach($ms->akar as $ak)
									<tr data-tt-id="PMD_{{$ak->id}}" data-tt-parent-id="PMD_{{$ak->id_parent}}">
										<td></td>
										<td>{{$ak->jenis}}</td>
										<td>
											<div class="btn-group">
												<button class="btn  btn-xs btn-danger" onclick="showForm('{{route('sink.daerah.permasalahan.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$ak->id])}}')"><i class="fa fa-trash"></i></button>
												<button class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.daerah.permasalahan.form.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$ak->id])}}')"><i class="fa fa-pen"></i></button>
												<button class="btn  btn-xs btn-success"  onclick="showForm('{{route('sink.daerah.permasalahan.form.add',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$ak->id])}}')"><i class="fa fa-plus"></i> DATA DUKUNG</button>
											</div>
										</td>
										<td>{{$ak->kategori}}</td>
								<td>{{$ak->uraian_sumber_data}}</td>
								<td>{{$ak->uraian}}</td>
								<td>{{$ak->implement?'IMPLEMENTED':'-'}}</td>

										



									</tr>
									@foreach($ak->data as $key=>$dt)
										<tr data-tt-id="PMD_{{$dt->id}}" data-tt-parent-id="PMD_{{$dt->id_parent}}">
											<td>
												
											</td>

											<td>{{$dt->jenis}} {{$key+1}}</td>
											<td>
												<div class="btn-group">
												<button class="btn  btn-xs btn-danger" onclick="showForm('{{route('sink.daerah.permasalahan.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$dt->id])}}')"><i class="fa fa-trash"></i></button>
												<button class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.daerah.permasalahan.form.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$dt->id])}}')"><i class="fa fa-pen"></i></button>
												</div>
											</td>
											<td>{{$dt->kategori}}</td>
											<td>{{$dt->uraian_sumber_data}}</td>
											<td>{{$dt->uraian}}</td>
											<td>{{$dt->implement?'IMPLEMENTED':'-'}}</td>
											



										</tr>
									@endforeach
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

	function showform(url){
		$.get(url,function(res){
			$('#modal_sm .modal-content').html(res);
			$('#modal_sm').modal();
		});
	}

</script>
@stop