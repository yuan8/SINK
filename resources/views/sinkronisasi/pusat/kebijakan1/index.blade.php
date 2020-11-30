@extends('adminlte::pusat')


    
@section('content_header')
    <h1>KEBIJAKAN  PUSAT 1 TAHUNAN - PEMETAAN TAHUN {{$GLOBALS['tahun_access']}}</h1>
    <div class="btn-group" style="margin-top: 10px;">
		<button class="btn btn-primary" id="btn-tambah-mandat" onclick="showForm('{{route('sink.pusat.kebijakan1.form_tambah',['tahun'=>$GLOBALS['tahun_access']])}}')">TAMBAH PN / MAJOR </button>
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
							<th colspan="9">INDIKATOR</th>

						</tr>
						<tr>
							<th>SUB URUSAN</th>
							<th style="min-width: 230px;">AKSI</th>

							<th style="min-width: 220px;">JENIS DATA</th>
							<th style="min-width: 230px;">URAIAN</th>
							<th style="min-width: 230px;">KETERANGAN</th>
							<th style="min-width: 100px;">AKSI INDIKATOR</th>
							<th>SUB URUSAN</th>
							<th>SUMBER DATA</th>
							<th>KODE</th>
							<th style="min-width: 230px;">INDIKATOR</th>
							<th>JENIS</th>
							<th>TARGET</th>
							<th>ARAH NILAI</th>

							<th>SATUAN</th>


						</tr>
					</thead>
					<tbody>
						<tbody>
							@foreach($data as $m)
								<tr class="bg-gray" data-tt-id="RKP_{{$m->id}}">
									<td>{{$m->nama_sub_urusan}}</td>
									<td>
										<div class="btn-group">
													<button class="btn  btn-xs btn-danger"
													onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$m->id])}}')"
													><i class="fa fa-trash"></i></button>
													<button  class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.pusat.kebijakan1.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$m->id])}}')"><i class="fa fa-pen"></i></button>
													@if($m->jenis!='MAJOR')
													<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$m->id])}}')"><i class="fa fa-plus"></i>PP</button>
													@endif
													@if($m->jenis=='MAJOR')
															<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form.ind.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$m->id])}}')"><i class="fa fa-plus" ></i> INDIKATOR</button>
													@endif
												</div>

									</td>
									<td>{{$m->jenis}}</td>
									
									<td>{{$m->uraian}}</td>
									<td>{!!nl2br($m->keterangan)!!}</td>
									<td colspan="9"></td>




								</tr>
								@foreach($m->indikator as $i)


									<tr  data-tt-parent-id="RKP_{{$i->id_rkp}}" data-tt-id="INDIKATOR_{{$i->id}}">
										<td></td>
										<td>
										</td>
										<td>INDIKATOR MAJOR</td>

										<td></td>
										<td></td>
										<td>
											<div class="btn-group">
												<button onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id_bridge])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
												<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
											</div>
										</td>
										<td>{{$i->nama_sub_urusan}}</td>
										<td>{{$i->sumber_data}}</td>
										<td>{{$i->kode}}</td>
										<td>{{$i->tolokukur}}</td>
										<td>{{$i->jenis}}</td>
										<td>
											{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
										</td>
										<td>{{$i->positiv_value?'POSITIF':'NEGATIF'}}</td>
										<td>
											{{$i->satuan}}
										</td>

										
									</tr>
								@endforeach

								@foreach($m->pp as $pp)
									<tr class=" bg-info" data-tt-parent-id="RKP_{{$pp->id_parent}}" data-tt-id="RKP_{{$pp->id}}">
										<td></td>
										<td>
											<div class="btn-group">
														<button class="btn  btn-xs btn-danger"
													onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$pp->id])}}')"
													><i class="fa fa-trash"></i></button>
													<button  class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.pusat.kebijakan1.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$pp->id])}}')"><i class="fa fa-pen"></i></button>
													<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$pp->id])}}')"><i class="fa fa-plus"></i>KP</button>
														<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form.ind.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$pp->id])}}')"><i class="fa fa-plus" ></i> INDIKATOR</button>
													</div>

										</td>
										<td>{{$pp->jenis}}</td>
										
										<td>{{$pp->uraian}}</td>
										<td>{!!nl2br($pp->keterangan)!!}</td>
										<td colspan="9"></td>





									</tr>

									@foreach($pp->indikator as $i)


									<tr data-tt-parent-id="RKP_{{$i->id_rkp}}" data-tt-id="INDIKATOR_{{$i->id}}">
										<td></td>
										<td>
										</td>
										<td>INDIKATOR PP</td>

										<td></td>
										<td></td>
										<td>
											<div class="btn-group">
												<button onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id_bridge])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
												<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
											</div>
										</td>
										<td>{{$i->nama_sub_urusan}}</td>
										<td>{{$i->sumber_data}}</td>
										<td>{{$i->kode}}</td>
										<td>{{$i->tolokukur}}</td>
										<td>{{$i->jenis}}</td>
										<td>
											{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
										</td>
										<td>{{$i->positiv_value?'POSITIF':'NEGATIF'}}</td>
										<td>
											{{$i->satuan}}
										</td>

										
									</tr>
								@endforeach

									@foreach($pp->kp as $kp)
										<tr class=" bg-info" data-tt-parent-id="RKP_{{$kp->id_parent}}" data-tt-id="RKP_{{$kp->id}}">
											<td></td>
											<td>
												<div class="btn-group">
													<button class="btn  btn-xs btn-danger"
													onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$kp->id])}}')"
													><i class="fa fa-trash"></i></button>
													<button  class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.pusat.kebijakan1.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$kp->id])}}')"><i class="fa fa-pen"></i></button>
													<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$kp->id])}}')"><i class="fa fa-plus"></i>PROPN</button>
														<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form.ind.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$kp->id])}}')"><i class="fa fa-plus" ></i> INDIKATOR</button>
												</div>

											</td>
											<td>{{$kp->jenis}}</td>
											
											<td>{{$kp->uraian}}</td>
											<td>{!!nl2br($kp->keterangan)!!}</td>
											<td colspan="9"></td>
										</tr>
											
											@foreach($kp->indikator as $i)
											<tr  data-tt-parent-id="RKP_{{$i->id_rkp}}" data-tt-id="INDIKATOR_{{$i->id}}">
													<td></td>
													<td>
													</td>
													<td>INDIKATOR KP</td>

													<td></td>
													<td></td>
													<td>
														sink.pusat.kebijakan1.form.delete.indikator
														<div class="btn-group">
															<button onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id_bridge])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
															<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
															<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
														</div>
													</td>
													<td>{{$i->nama_sub_urusan}}</td>
													<td>{{$i->sumber_data}}</td>
													<td>{{$i->kode}}</td>
													<td>{{$i->tolokukur}}</td>
													<td>{{$i->jenis}}</td>
													<td>
														{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
													</td>
													<td>{{$i->positiv_value?'POSITIF':'NEGATIF'}}</td>
													<td>
														{{$i->satuan}}
													</td>

													
												</tr>
											@endforeach
											@foreach($kp->propn as $propn)
												<tr class=" bg-info" data-tt-parent-id="RKP_{{$propn->id_parent}}" data-tt-id="RKP_{{$propn->id}}">
													<td></td>
													<td>
														<div class="btn-group">
															<button class="btn  btn-xs btn-danger"
													onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$propn->id])}}')"
													><i class="fa fa-trash"></i></button>
													<button  class="btn  btn-xs btn-warning" onclick="showForm('{{route('sink.pusat.kebijakan1.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$propn->id])}}')"><i class="fa fa-pen"></i></button>
													<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$propn->id])}}')"><i class="fa fa-plus"></i>PROYEK</button>
														<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.kebijakan1.form.ind.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$propn->id])}}')"><i class="fa fa-plus" ></i> INDIKATOR</button>
														</div>

													</td>
													<td>{{$propn->jenis}}</td>
													
													<td>{{$propn->uraian}}</td>
													<td>{!!nl2br($propn->keterangan)!!}</td>
													<td colspan="9"></td>
												</tr>
													
												@foreach($propn->indikator as $i) <tr  data-tt-parent-id="RKP_{{$i->id_rkp}}" data-tt-id="INDIKATOR_{{$i->id}}">
														<td></td>
														<td>
														</td>
														<td>INDIKATOR PROPN</td>

														<td></td>
														<td></td>
														<td>
															<div class="btn-group">
																<button onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id_bridge])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
																<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
																<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
															</div>
														</td>
														<td>{{$i->nama_sub_urusan}}</td>
														<td>{{$i->sumber_data}}</td>
														<td>{{$i->kode}}</td>
														<td>{{$i->tolokukur}}</td>
														<td>{{$i->jenis}}</td>
														<td>
															{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
														</td>
														<td>{{$i->positiv_value?'POSITIF':'NEGATIF'}}</td>
														<td>
															{{$i->satuan}}
														</td>

														
													</tr>
												@endforeach
												@foreach($propn->proyek as $proyek)
												<tr class=" bg-info" data-tt-parent-id="RKP_{{$proyek->id_parent}}" data-tt-id="RKP_{{$proyek->id}}">
													<td></td>
													<td>
														<div class="btn-group">
															<button class="btn  btn-xs btn-danger"
													onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$proyek->id])}}')"
													><i class="fa fa-trash"></i></button>
															<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
															
															<button class="btn  btn-xs btn-success" onclick="showform('{{route('sink.pusat.kebijakan1.form.ind.form_tambah',['tahun'=>$GLOBALS['tahun_access'],'id'=>$proyek->id])}}')"><i class="fa fa-plus" ></i> INDIKATOR</button>
														</div>

													</td>
													<td>{{$proyek->jenis}}</td>
													
													<td>{{$proyek->uraian}}</td>
													<td>{!!nl2br($proyek->keterangan)!!}</td>
													<td colspan="9"></td>
												</tr>
													
												@foreach($proyek->indikator as $i)


													<tr data-tt-parent-id="RKP_{{$i->id_rkp}}" data-tt-id="INDIKATOR_{{$i->id}}">
														<td></td>
														<td>
														</td>
														<td>INDIKATOR PROYEK</td>

														<td></td>
														<td></td>
														<td>
															<div class="btn-group">
																<button onclick="showForm('{{route('sink.pusat.kebijakan1.form.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id_bridge])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
																<button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
																<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
															</div>
														</td>
														<td>{{$i->nama_sub_urusan}}</td>
														<td>{{$i->sumber_data}}</td>
														<td>{{$i->kode}}</td>
														<td>{{$i->tolokukur}}</td>
														<td>{{$i->jenis}}</td>
														<td>
															{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
														</td>
														<td>{{$i->positiv_value?'POSITIF':'NEGATIF'}}</td>
														<td>
															{{$i->satuan}}
														</td>

														
													</tr>
												@endforeach
											@endforeach
											@endforeach





									@endforeach
								@endforeach
							@endforeach
						</tbody>
					</tbody>
				</table>
			</div>
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
