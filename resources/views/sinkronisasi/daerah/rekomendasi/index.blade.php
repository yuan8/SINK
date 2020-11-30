@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')

@section('content_header')
    <h1>REKOMENDASI RKPD  {{$GLOBALS['pemda_access']->nama_pemda}} BERLAKU TAHUN {{$GLOBALS['tahun_access']+1}}</h1>
    <div class="btn-group" style="margin-top: 3px;">
{{--   		<button class="btn btn-primary" onclick='showForm("{{route('sink.daerah.rekomendasi.permasalahan_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access']])}}","lg")'><i class="fa fa-plus"></i> PERMASALAHAN</button> --}}
  		{{-- <button class="btn btn-primary" onclick='showForm("{{route('sink.daerah.rekomendasi.nomen_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access']])}}","lg")'><i class="fa fa-eye"></i>  NOMENKLATUR</button> --}}
  	</div>
  			
@stop




@section('content')
    <div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body table-responsive" style="max-height: 500px;">
					<table class="table table-bordered sticky-table" id="treetable-init">
						<thead>
							<tr>
								<th colspan="10">RKPD</th>
								<th colspan="9">INDIKATOR</th>

							</tr>
							<tr>
								<th>SUB URUSAN</th>
								<th style="min-width: 280px;">JENIS</th>
								<th>AKSI PERMASALAHAN</th>
								<th style="min-width: 300px;">PERMASALAHAN</th>
								<th style="min-width:150px;">AKSI NOMENKLATUR</th>
								<th style="min-width: 200px;">DUKUNGAN PUSAT</th>

								<th>KODE NOMENKLATUR</th>
								<th style="min-width: 280px;">URAIAN</th>
								<th style="min-width: 100px;">PAGU</th>
								<th>KETERANGAN</th>
								<th style="min-width: 100px;">SUMBER DATA</th>
								<th>JENIS</th>
								<th style="min-width: 200px;">TOLOKUKUR</th>
								<th>ARAH NILAI</th>
								<th>TARGET PUSAT</th>
								<th>TARGET DAERAH</th>
								<th>SATUAN</th>
								<th style="min-width: 200px;">KETERANGAN</th>


							</tr>
						</thead>
						<tbody>
							@foreach($data as $ms)
								<tr  class="bg-navy text-dark" data-tt-id="ms_{{$ms->id}}">
									<td>-</td>
									<td scope="row">{{$ms->jenis}} </td>
									<td>
										<div class=btn-group-vertical>
											<button onclick='showForm("{{route('sink.daerah.rekomendasi.nomen_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>null])}}?id_ms={{$ms->id}}","lg")' class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> NOMENKLATUR</button>
											<button onclick='showForm("{{route('sink.daerah.rekomendasi.permasalahan_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$ms->id])}}","lg")' class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> PERMASALAHAN</button>
										</div>
									</td>

									<td>{{$ms->uraian}}</td>
									<td colspan="14"></td>
								</tr>
								@foreach($ms->nomenklatur as $nomen)
									<tr class="bg-info" data-tt-id="nomen_{{$nomen->id_bridge}}" data-tt-parent-id="ms_{{$nomen->id_ms_bridge}}">
										<td>-</td>
									<td scope="row">{!!HPV::c_icon(1)!!} {{$nomen->jenis}} </td>

										<td>

										</td>
										<td>
											 
										</td>
										<td>
										<div class="btn-group" style="margin-bottom: 3px;"> 
											<button onclick="showForm('{{route('sink.daerah.rekomendasi.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$nomen->id_bridge])}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>
											<button onclick="showForm('{{route('sink.daerah.rekomendasi.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$nomen->id_bridge])}}')" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> </button>
											
										</div>
										<div class="btn-group">
											<div class=btn-group>
											<button onclick='showForm("{{route('sink.daerah.rekomendasi.nomen_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$nomen->id_bridge])}}","lg")' class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> NOMENKLATUR</button>
										
												
											<button onclick='showForm("{{route('sink.daerah.rekomendasi.ind_list',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$nomen->id_bridge,'tipe'=>['OUTCOME','IMPACT']])}}","lg")'  class="btn btn-success btn-xs"><i class="fa fa-plus"></i> INDIKATOR</button>
										</div>
										</td>
										<td></td>
										
										<td>{{$nomen->kode}}</td>
										<td scope="row">{!!HPV::c_icon(1)!!} {{$nomen->uraian}}</td>
										<td>Rp. {{number_format($nomen->pagu_cal)}}</td>
										<td>{!!nl2br($nomen->keterangan)!!}</td>

										<td colspan="8"></td>
									</tr>
									@foreach($nomen->indikator as $ip)
									<tr data-tt-id="i_{{$ip->id}}" data-tt-parent-id="nomen_{{$ip->id_parent_bridge}}">
										<td>-</td>
									<td scope="row">INDIKATOR PROGRAM </td>

										<td>

										</td>
										<td>
											 
										</td>
											<td>
										<div class="btn-group" style="margin-bottom: 3px;"> 
											<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>
											<button class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> </button>
											<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$ip->id])}}','lg')"  class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
											<button class="btn btn-xs bg-navy" onclick="showForm('{{route('sink.pusat.indikator.child_line',['tahun'=>$GLOBALS['tahun_access'],'id'=>$ip->id])}}','lg')">
												<i class="ion ion-merge"></i>
											</button>
										</div>
										
										</td>
										<td>
											<ol>
											@php 
												$dukungan_pusat=[];
												$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$ip->dukungan_pusat_lainya));
												$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$ip->dukungan_rkp));
												

												
												$dukungan_pusat=array_unique($dukungan_pusat);
											@endphp

											@foreach($dukungan_pusat as $dp)
												@if(!empty($dp))
												<li>{!!$dp!!}</li>
												@endif
											@endforeach
											</ol>
										</td>
									
										<td colspan="4"></td>
										<td>{{$ip->sumber_data}}</td>
										<td>{{$ip->jenis}}</td>
										<td>{{$ip->tolokukur}}</td>
										<td>{{($ip->positiv_value?'POSITIF':'NEGATIF')}}</td>
										<td>
											{{!empty($ip->target_pusat_2)?number_format($ip->target_pusat).' - '.number_format($ip->target_pusat_2):number_format($ip->target_pusat)}}

										</td>
									
										<td>
												{{!empty($ip->target_2)?number_format($ip->target).' - '.number_format($ip->target_2):number_format($ip->target)}}
										</td>
										<td>{{$ip->satuan}}</td>
										<td>{!!nl2br($ip->keterangan)!!}</td>
									</tr>
									@endforeach
									@foreach($nomen->kegiatan as $k)
										<tr class="bg-success" data-tt-id="nomen_{{$k->id_bridge}}" data-tt-parent-id="nomen_{{$k->id_parent_bridge}}">
											<td>-</td>
									<td scope="row">{!!HPV::c_icon(2)!!} {{$k->jenis}} </td>

											<td>	
											</td>
											<td>
												@if(!empty($k->id_ms))
												 	<p><b>{{$k->ms_kategori}}</b></p>

													{{$k->ms_jenis}} :
												 	{{$k->ms_uraian}}
												@else
													<p class="text-danger">Permasalahan Belum Di Tagging</p>
												@endif
											</td>
											<td>
											<div class="btn-group" style="margin-bottom: 3px;"> 
												<button onclick="showForm('{{route('sink.daerah.rekomendasi.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$k->id_bridge])}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>
												<button onclick="showForm('{{route('sink.daerah.rekomendasi.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$k->id_bridge])}}')" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> </button>
											</div>
											<div class="btn-group">
												<div class=btn-group>
												<button onclick='showForm("{{route('sink.daerah.rekomendasi.nomen_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$k->id_bridge])}}","lg")' class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> NOMENKLATUR</button>
												<button onclick='showForm("{{route('sink.daerah.rekomendasi.ind_list',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$k->id_bridge,'tipe'=>['OUTPUT']])}}","lg")'  class="btn btn-success btn-xs"><i class="fa fa-plus"></i> INDIKATOR</button>
											</div>
											</td>
											<td></td>
											
										<td>{{$k->kode}}</td>

											<td scope="row"><p style="margin-left: 30px;">
												{!!HPV::c_icon(2)!!} {{$k->uraian}}</p></td>
											<td>Rp. {{number_format($k->pagu)}}</td>
											<td>{!!nl2br($k->keterangan)!!}</td>
											<td colspan="8"></td>
										</tr>
										@foreach($k->indikator as $ik)
											<tr  data-tt-id="i_{{$ik->id}}" data-tt-parent-id="nomen_{{$ik->id_parent_bridge}}">
												<td>-</td>
											<td scope="row">INDIKATOR KEGIATAN </td>
												<td>
												</td>
												<td> 
												</td>
													<td>
												<div class="btn-group" style="margin-bottom: 3px;"> 
													<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>
													<button class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> </button>
												<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$ik->id])}}','lg')"  class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
												<button class="btn btn-xs bg-navy" onclick="showForm('{{route('sink.pusat.indikator.child_line',['tahun'=>$GLOBALS['tahun_access'],'id'=>$ik->id])}}','lg')">
													<i class="ion ion-merge"></i>
												</button>
												</div>
												
												</td>
												<td>
													<ol>
													@php 
														$dukungan_pusat=[];
														$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$ik->dukungan_pusat_lainya));
														$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$ik->dukungan_rkp));
														
														$dukungan_pusat=array_unique($dukungan_pusat);


													@endphp

													@foreach($dukungan_pusat as $dp)
														@if(!empty($dp))
														<li>{!!$dp!!}</li>
														@endif
													@endforeach
													</ol>
												</td>
											
												<td colspan="4"></td>
												<td>{{$ik->sumber_data}}</td>
												<td>{{$ik->jenis}}</td>
												<td>{{$ik->tolokukur}}</td>
												<td>{{($ik->positiv_value?'POSITIF':'NEGATIF')}}</td>
												<td>
													{{!empty($ik->target_pusat_2)?number_format($ik->target_pusat).' - '.number_format($ik->target_pusat_2):number_format($ik->target_pusat)}}

												</td>
											
												<td>
														{{!empty($ik->target_2)?number_format($ik->target).' - '.number_format($ik->target_2):number_format($ik->target)}}
												</td>
												<td>{{$ik->satuan}}</td>
												<td>{!!nl2br($ik->keterangan)!!}</td>
											</tr>
											@endforeach
											@foreach($k->subkegiatan as $su)
											<tr  class="bg-warning" data-tt-id="nomen_{{$su->id_bridge}}" data-tt-parent-id="nomen_{{$su->id_parent_bridge}}">
												<td>-</td>
												<td scope="row">{!!HPV::c_icon(3)!!} {{$su->jenis}}  </td>

												<td>	
												</td>
												<td>
													
													@if($su->id_ms)
														{{$su->ms_jenis}} :
													 {{$su->ms_uraian}}
													@else
														<p class="text-danger">Permasalahan Belum Di Tagging</p>
													@endif
												</td>
													<td>
												<div class="btn-group" style="margin-bottom: 3px;"> 
													<button onclick="showForm('{{route('sink.daerah.rekomendasi.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$su->id_bridge])}}')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>
													<button onclick="showForm('{{route('sink.daerah.rekomendasi.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$su->id_bridge])}}')" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> </button>
													<button onclick='showForm("{{route('sink.daerah.rekomendasi.ind_list',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$su->id_bridge,'tipe'=>['OUTPUT']])}}","lg")'  class="btn btn-success btn-xs"><i class="fa fa-plus"></i> INDIKATOR</button>
												</div>
												
												</td>
												<td></td>
											
										<td>{{$su->kode}}</td>

												<td scope="row"><p style="margin-left: 60px;">
													{!!HPV::c_icon(3)!!} {{$su->uraian}}</p></td>
												<td>Rp. {{number_format($su->pagu)}}</td>
												<td>{!!nl2br($su->keterangan)!!}</td>

												<td colspan="8"></td>
											</tr>
											@foreach($su->indikator as $isu)
												<tr data-tt-id="i_{{$isu->id}}" data-tt-parent-id="nomen_{{$isu->id_parent_bridge}}">
													<td>-</td>
												<td scope="row">INDIKATOR SUB KEGIATAN </td>
													<td>
													</td>
													<td> 
													</td>
													
													<td>
													<div class="btn-group" style="margin-bottom: 3px;"> 
														<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>
														<button class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> </button>
														<button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$isu->id])}}','lg')"  class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
														<button class="btn btn-xs bg-navy" onclick="showForm('{{route('sink.pusat.indikator.child_line',['tahun'=>$GLOBALS['tahun_access'],'id'=>$isu->id])}}','lg')">
													<i class="ion ion-merge"></i>
												</button>
													</div>
													
													</td>
													<td>
														<ol>
														@php 
															$dukungan_pusat=[];
															$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$isu->dukungan_pusat_lainya));
															$dukungan_pusat=array_merge($dukungan_pusat,explode('||',$isu->dukungan_rkp));
														
															$dukungan_pusat=array_unique($dukungan_pusat);

														@endphp

														@foreach($dukungan_pusat as $dp)
															@if(!empty($dp))
																<li>{!!$dp!!}</li>
																@endif
														@endforeach
														</ol>
													</td>
													<td colspan="4"></td>
													<td>{{$isu->sumber_data}}</td>
													<td>{{$isu->jenis}}</td>
													<td>{{$isu->tolokukur}}</td>
													<td>{{($isu->positiv_value?'POSITIF':'NEGATIF')}}</td>
													<td>
														{{!empty($isu->target_pusat_2)?number_format($isu->target_pusat).' - '.number_format($isu->target_pusat_2):number_format($isu->target_pusat)}}

													</td>
												
													<td>
															{{!empty($isu->target_2)?number_format($isu->target).' - '.number_format($isu->target_2):number_format($isu->target)}}
													</td>
													<td>{{$isu->satuan}}</td>
													<td>{!!nl2br($isu->keterangan)!!}</td>
												</tr>
											@endforeach
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