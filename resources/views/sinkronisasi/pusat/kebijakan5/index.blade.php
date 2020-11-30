@extends('adminlte::pusat')


    
@section('content_header')
    <h1>KEBIJAKAN  PUSAT 5 TAHUNAN RPJMN {{HPV::rpjmn_now($GLOBALS['tahun_access'])}}- PEMETAAN TAHUN {{$GLOBALS['tahun_access']}}</h1>
    <div class="btn-group" style="margin-top: 10px;">
		<button class="btn btn-primary" id="btn-tambah-mandat" onclick="showForm('{{route('sink.pusat.kebijakan5.add',['tahun'=>$GLOBALS['tahun_access']])}}')">TAMBAH KONDISI SAAT INI</button>
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
								<th colspan="5">PEMETAAN</th>
								<th colspan="10">INDIKATOR</th>

							</tr>
							<tr>
								<th>SUB URUSAN</th>
								<th style="min-width: 200px;">AKSI</th>

								<th style="min-width: 230px;">JENIS DATA</th>
								<th style="min-width: 230px;">URAIAN</th>
								<th style="min-width: 230px;">KETERANGAN</th>
								<th style="min-width: 100px;">AKSI INDIKATOR</th>
								<th>SUB URUSAN</th>
								<th>SUMBER DATA</th>
								<th>JENIS</th>

								<th>KODE</th>

								<th style="min-width: 230px;">INDIKATOR</th>
								<th>TARGET</th>
								<th>ARAH NILAI</th>

								<th>SATUAN</th>


							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr data-tt-id="KONDISI_{{$d->id}}">
									<td>{{$d->nama_sub_urusan}}</td>
												<td>
										<div class="btn-group">
													<button onclick="showForm('{{route('sink.pusat.kebijakan5.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan5.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan5.add',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id])}}')" class="btn  btn-xs btn-success"><i class="fa fa-plus"></i> ISU STARTEGIS</button>
												</div>

									</td>
									<td>{{$d->jenis}}</td>
						
									<td>{{$d->uraian}}</td>
									<td>{!!nl2br($d->keterangan)!!}</td>
									<td colspan="10"></td>




								</tr>
								@foreach($d->isu as $isu)
									<tr data-tt-parent-id="KONDISI_{{$d->id}}" data-tt-id="ISU_{{$isu->id}}">
										<td></td>
											<td>
											<div class="btn-group">
														<button onclick="showForm('{{route('sink.pusat.kebijakan5.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$isu->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan5.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$isu->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
														<button onclick="showForm('{{route('sink.pusat.kebijakan5.add',['tahun'=>$GLOBALS['tahun_access'],'id'=>$isu->id])}}')"  class="btn  btn-xs btn-success"><i class="fa fa-plus"></i> ARAH KEBIJAKAN</button>
													</div>

										</td>
										<td>{{$isu->jenis}}</td>
									
										<td>{{$isu->uraian}}</td>
										<td>{!!nl2br($isu->keterangan)!!}</td>
										<td colspan="10"></td>





									</tr>
									@foreach($isu->arah_kebijakan as $kb)
										<tr data-tt-parent-id="ISU_{{$kb->id_parent}}" data-tt-id="KEBIJAKAN_{{$kb->id}}">
											<td></td>
											<td>
												<div class="btn-group">
													<button onclick="showForm('{{route('sink.pusat.kebijakan5.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$kb->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.pusat.kebijakan5.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$kb->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
													<button class="btn  btn-xs btn-success" onclick="showform('{{route('sink.pusat.kebijakan5.form.ind.tagging',['tahun'=>$GLOBALS['tahun_access'],'id_rpjmn'=>$kb->id])}}')"><i class="fa fa-plus" ></i> INDIKATOR</button>
												</div>

											</td>
											<td>{{$kb->jenis}}</td>
											
											<td>{{$kb->uraian}}</td>
											<td>{!!nl2br($kb->keterangan)!!}</td>
											<td colspan="10"></td>
											
											@foreach($kb->indikator as $i)


												<tr data-tt-parent-id="KEBIJAKAN_{{$i->id_rpjmn}}" data-tt-id="INDIKATOR_{{$i->id}}">
													<td></td>
													<td>
														

													</td>
													<td>INDIKATOR ARAH KEBIJAKAN</td>

													<td></td>
													<td></td>
													<td>
														<div class="btn-group">
															<button onclick="showForm('{{route('sink.pusat.kebijakan5.form.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id_bridge])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
															<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
															<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
														</div>
													</td>
													<td>{{$i->nama_sub_urusan}}</td>
													<td>{!!$i->sumber_data!!}</td>
													<td>{{$i->jenis}}</td>


													<td>{{$i->kode}}</td>
													<td>{{$i->tolokukur}}</td>
													<td>
														{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
													</td>
													<td>
														{{$i->positiv_value?'POSITIF':'NEGATIF'}}
													</td>
													<td>
														{{$i->satuan}}
													</td>

													
												</tr>
											@endforeach



										</tr>
									@endforeach
								@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
@stop

@section('js')
<script type="text/javascript">
	
	$('#treetable-init').treetable({ expandable: true,column:2,initialState:'expanded' });

	function showform(url){
		$.get(url,function(res){
			$('#modal_lg .modal-content').html(res);
			$('#modal_lg').modal();
		});
	}

</script>
@stop