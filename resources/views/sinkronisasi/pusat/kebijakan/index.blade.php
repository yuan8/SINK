@extends('adminlte::pusat')


@section('content_header')
    <h1>KEBIJAKAN PUSAT BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>
    <div class="btn-group" style="margin-top: 10px;">
		<button class="btn btn-primary" id="btn-tambah-mandat" onclick="$('#form_add_mandat').modal()">TAMBAH MANDAT</button>
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
								<th>AKSI MANDAT</th>
								<th>MANDAT</th>
								<th>JENIS</th>

								<th>AKSI UU</th>
								<th>UNDANG-UNDANG</th>
								<th>AKSI PP</th>

								<th>PERATURAN PEMERINTAH</th>
								<th>AKSI PERMEN</th>

								<th>PERATURAN MENTRI</th>
								<th>AKSI PERPRES</th>

								<th>PERATURAN PRESINDEN</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr data-tt-id="mandat_{{$d->id}}">
									<td>{{$d->nama_sub_urusan}}</td>
									<td>
										<div class="btn-group">
											<button class="btn  btn-xs btn-danger" onclick="showform('{{route('sink.pusat.kebijakan.mandat.form_del',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')"><i class="fa fa-trash"></i></button>
											<button class="btn  btn-xs btn-warning" onclick="showform('{{route('sink.pusat.kebijakan.mandat.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" ><i class="fa fa-pen"></i></button>
										</div>
									</td>
									<td><span>{!!nl2br($d->uraian)!!} ({{number_format($d->child_count)}})</span>
									</td>
									<td>
										{{$d->jenis}}
									</td>
									<td >
										
									</td>
									<td>
										<button class="btn  btn-xs btn-success col-md-12" onclick="showform('{{route('sink.pusat.kebijakan.mandat.add.kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'context'=>'UU'])}}')"><i class="fa fa-plus"></i> UU</button>
									</td>
									<td >
										
									</td>
									<td>
										<button class="btn  btn-xs btn-success col-md-12" onclick="showform('{{route('sink.pusat.kebijakan.mandat.add.kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'context'=>'PP'])}}')"><i class="fa fa-plus"></i> PP</button>
									</td>
									<td >
										
									</td>
									<td>
										<button class="btn  btn-xs btn-success col-md-12" onclick="showform('{{route('sink.pusat.kebijakan.mandat.add.kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'context'=>'PERMEN'])}}')"><i class="fa fa-plus"></i> PERMEN</button>
									</td>
									<td >
										
									</td>
									<td>
										<button class="btn  btn-xs btn-success col-md-12" onclick="showform('{{route('sink.pusat.kebijakan.mandat.add.kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'context'=>'PERPRES'])}}')"><i class="fa fa-plus"></i> PERPRES</button>
									</td>
									@for($i=0;$i<$d->child_count;$i++)

									<tr data-tt-parent-id="mandat_{{$d->id}}" data-tt-id="kb_{{$d->id}}_{{$i}}" >
										<td>
											
										</td>
										<td>
											
										</td>

										<td style="min-width: 200px;">
											<span>{!!HPV::c_icon(1)!!} REGULASI</span>
										</td>
										<td></td>
										<td style="min-width: 80px;">
											@isset($d->uu[$i])
												<div class="btn-group">
													<button onclick="showForm('{{route('sink.pusat.kebijakan.kb.form.del',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->uu[$i]->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan.edit_kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->uu[$i]->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												</div>
											@endisset
										</td>
										<td>
											@isset($d->uu[$i])
											{{$i+1}}. {!! nl2br($d->uu[$i]->jenis.'/'.$d->uu[$i]->tahun_berlaku.' - '.$d->uu[$i]->uraian)!!}
											@endisset
										</td>
										<td style="min-width: 80px;">
											@isset($d->pp[$i])
												<div class="btn-group">
													<button onclick="showForm('{{route('sink.pusat.kebijakan.kb.form.del',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->pp[$i]->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan.edit_kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->pp[$i]->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												</div>
											@endisset
										</td>

										<td>
											@isset($d->pp[$i])
												{{$i+1}}. {!! nl2br($d->pp[$i]->jenis.'/'.$d->pp[$i]->tahun_berlaku.' - '.$d->pp[$i]->uraian)!!}
											@endisset
										</td>
										<td style="min-width: 80px;">
											@isset($d->permen[$i])
												<div class="btn-group">
													<button onclick="showForm('{{route('sink.pusat.kebijakan.kb.form.del',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->permen[$i]->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan.edit_kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->permen[$i]->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												</div>
											@endisset
										</td>
										<td>
											@isset($d->permen[$i])
												{{$i+1}}. {!! nl2br($d->permen[$i]->jenis.'/'.$d->permen[$i]->tahun_berlaku.' - '.$d->permen[$i]->uraian)!!}
											@endisset
										</td>
										<td style="min-width: 80px;">
											@isset($d->perpres[$i])
												<div class="btn-group">
													<button onclick="showForm('{{route('sink.pusat.kebijakan.kb.form.del',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->perpres[$i]->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan.edit_kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->perpres[$i]->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												</div>
											@endisset
										</td>
											<td>
											@isset($d->perpres[$i])
												{{$i+1}}. {!! nl2br($d->perpres[$i]->jenis.'/'.$d->perpres[$i]->tahun_berlaku.' - '.$d->perpres[$i]->uraian)!!}
											@endisset
										</td>
									</tr>
									@endfor




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
@include('sinkronisasi.pusat.kebijakan.partial.form_add_mandat')
<script type="text/javascript">
	
	$('#treetable-init').treetable({ expandable: true,column:2,initialState:'expanded' });

	function showform(url){
		$.get(url,function(res){
			$('#modal_sm .modal-content').html(res);
			$('#modal_sm').modal();
		});
	}

</script>
@stop