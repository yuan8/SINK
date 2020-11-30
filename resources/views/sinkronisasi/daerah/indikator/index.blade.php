@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')

@section('content_header')
  	<h1 class="">INDIKATOR PUSAT DAN TARAGET DAERAH TAHUN {{$GLOBALS['tahun_access']}}</h1>
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
								<th>IMPLEMENTASI</th>

								<th>SUB URUSAN</th>
								<th>DUKUNGAN PUSAT</th>

								<th>KODE</th>
								<th>JENIS</th>

								<th>TOLOKUKUR</th>
								<th>JENIS NILAI</th>

								<th>TARGET PUSAT</th>
								<th>AGREGASI TARGET DAERAH</th>

								<th>SATUAN</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $i)
								<tr>
									<td style="min-width: 100px">
										<div class="btn-group">
											@can('accessPusat')
											 <button class="btn  btn-xs btn-danger" onclick="showForm('{{route('sink.pusat.indikator.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')"><i class="fa fa-trash"></i></button>
                     						 <button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
											@endcan

											<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')"  class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
											<button class="btn btn-xs bg-navy" onclick="showform('{{route('sink.pusat.indikator.child_line',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')">
												<i class="ion ion-merge"></i>
											</button>
										</div>
									</td>
									<td>
										{{$i->implement?'IMPLEMENTED':'-'}}
									</td>
									<td>{{$i->nama_sub_urusan}}</td>
									<td>
										<ol>
													@php 
														$dukungan_pusat=[];
														$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$i->dukungan_pusat_lainya));
														$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$i->dukungan_rkp));
														
														$dukungan_pusat=array_unique($dukungan_pusat);


													@endphp

													@foreach($dukungan_pusat as $dp)
														@if(!empty($dp))
														<li>{!!$dp!!}</li>
														@endif
													@endforeach
													</ol>
									</td>
									<td>{{$i->kode}}</td>
									<td>{{$i->jenis}}</td>


									<td>{{$i->tolokukur}}</td>
									<td>{{$i->positiv_value?'POSITIV':'NEGATIF'}}</td>

									<td>
										{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
									</td>
									<td>
										{{$i->aggregate_target?($i->aggregate_target==-1?'TARGET TIDAK DAPAT DI UKUR':number_format($i->aggregate_target)):'-'}}
									</td>
									<td>
										{{$i->satuan}}
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
	
	$('#datatable-init').dataTable();
	function showform(url,size='lg'){
		$.get(url,function(res){
			$('#modal_'+size+' .modal-content').html(res);
			$('#modal_'+size).modal();
		});
	}

</script>
@stop