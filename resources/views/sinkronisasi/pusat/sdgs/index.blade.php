@extends('adminlte::pusat')


@section('content_header')
    <h1 class="">SDGS TAHUN DALAM RPJMN {{HPV::rpjmn_now($GLOBALS['tahun_access'])}} - PEMATAAN  TAHUN {{$GLOBALS['tahun_access']}}</h1>
    
    
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body table-responsive"  style="max-height: 500px;">
				<table class="table table-bordered sticky-table" id="treetable-init">
					<thead>
						<tr>
							<th colspan="4">SDGS</th>
							<th colspan="7">INDIKATOR</th>

						</tr>
						<tr>
							<th style="min-width: 280px;">JENIS</th>
							<th style="min-width: 300px;">URAIAN</th>
							<th style="min-width: 200px;">PELAKSANA</th>
							<th style="width: 50px;">AKSI</th>
							<th>SUB URUSAN</th>
							<th>SUMBER DATA</th>
							<th>JENIS</th>
							<th style="min-width: 300px;">TOLOKUKUR</th>
							<th>ARAH NILAI</th>
							<th>TARGET</th>
							<th>SATUAN</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $d)
							<tr data-tt-id="sdgs_{{$d->id}}" >
								<td scope="row">{{$d->jenis}}</td>
								<td>{!!nl2br($d->uraian)!!}</td>
								<td colspan="9"></td>
								


							</tr>
								@foreach($d->child as $s)
								<tr data-tt-id="sdgs_{{$s->id}}" data-tt-parent-id="sdgs_{{$s->id_parent}}">
									
									<td scope="row">{{$s->jenis}}</td>
									<td>{!!nl2br($s->uraian)!!}</td>
									<td colspan="9"></td>


								</tr>
								@foreach($s->child as $n)
									<tr data-tt-id="sdgs_{{$n->id}}" data-tt-parent-id="sdgs_{{$n->id_parent}}">
										<td scope="row">{{$n->jenis}}</td>
										<td>{!!nl2br($n->uraian)!!}</td>
										<td>{!!nl2br($n->pelaksana)!!}</td>
										<td>
											<div class="btn-group">
													
													<button class="btn  btn-xs btn-success" onclick="showForm('{{route('sink.pusat.sdgs.add',['tahun'=>$GLOBALS['tahun_access'],'id'=>$n->id])}}')" ><i class="fa fa-plus"></i> INDIKATOR</button>
													
												</div>

										</td>
										<td colspan="8"></td>




									</tr>

									@foreach($n->indikator as $i)


												<tr data-tt-parent-id="sdgs_{{$n->id}}" data-tt-id="INDIKATOR_{{$i->id}}">
													
													<td scope="row">INDIKATOR SASARAN NASIONAL</td>

													<td colspan="2"></td>
													<td>
														<div class="btn-group">
															<button class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
															
															<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
														</div>
													</td>
													<td>{{$i->nama_sub_urusan}}</td>
													<td>{!!$i->sumber_data!!}</td>
													<td>{{$i->jenis}}</td>
													<td>{{$i->tolokukur}}</td>
													<td>
														{{$i->positiv_value?'POSITIF':'NEGATIF'}}
													</td>
													<td>
														{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
													</td>
													
													<td>
														{{$i->satuan}}
													</td>

													
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
	
	$('#treetable-init').treetable({ expandable: true,column:0,initialState:'expanded' });


</script>
@stop