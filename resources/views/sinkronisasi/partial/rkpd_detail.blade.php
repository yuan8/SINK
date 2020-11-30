@php
$dom_id_rkpd_detail='rkpd-'.rand(11,99);
@endphp
<table class="table table-bordered sticky-table" id="treetable-init-{{$dom_id_rkpd_detail}}">
						<thead>
							<tr>
								<th>VISI</th>
								<th>MISI</th>
								<th>SASARAN</th>
								<th style="min-width: 170px;">JENIS</th>
								<th>KODE</th>
								<th style="min-width: 300px;">URAIAN</th>
								<th>PAGU</th>
								<th>ANGGARAN</th>
								<th>TARGET</th>
								<th>SATUAN</th>
								@if(!isset($editable))
								<th>AKSI PROGRES</th>
								@endif
								<th>CAPAIAN</th>
								<th>PROGRES PELAKSANAAN</th>
								@if(!isset($editable))
								
								<th>AKSI PERMASAlAHAN</th>
								@endif

								<th>PERMASALAHAN</th>

								<th>TINDAK LANJUT</th>
								<th>REKOMENDASI TARGET</th>

							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								@php
								$di=HPV::rkpd_nes($d);
								@endphp
								<tr class="bg-ifo">
									<td colspan="5" >
										<p class="w-space" style="max-width: 90%">PROGRESS {{$di['uraian']}}</p>
									</td>
									<td colspan="12" scope="row">
									<span class="">{{number_format($d->progress??0,1)}}% Complete</span>
										 <div class="progress xs">

				                            <div class="progress-bar progress-bar-aqua" style="width: {{number_format($d->progress??0,2)}}%" role="progressbar" aria-valuenow="{{number_format($d->progress??0,2)}}" aria-valuemin="0" aria-valuemax="100">
				                              <span class="sr-only">{{number_format($d->progress??0,1)}}% Complete</span>
				                            </div>
                         			 </div>
									</td>
								</tr>
								<tr class="bg-info" data-tt-id="{{$di['id']}}"  data-tt-parent-id="{{$di['parent']}}" >
									
									<td></td>
									<td></td>
									<td></td>
									<td scope="row">{{$di['jenis']}}</td>
									<td>{{$di['kode']}}</td>
									<td>
										{!!!empty($di['bidang'])?'<p><b>'.$di['bidang'].'</b></p>':''!!}
										{!!!empty($di['skpd'])?'<p><b>'.$di['skpd'].'</b></p>':''!!}
										<i>{!!HPV::c_icon(1).' '.$di['uraian']!!}</i>
									</td>
									</td>
									<td>Rp. {{number_format($di['pagu'])}}</td>
									<td>
										Rp.0
										<p><b>Realiasi Rp.0 (0%)</b></p>
									</td>
									<td>{{$di['target']}}</td>
									<td>{{$di['satuan']}}</td>
									@if(!isset($editable))
									{{-- aksi progress --}}
										<td>
										<div class="btn-group">
											<button onclick="showForm('{{route('sink.daerah.rkpd.edit_progres',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$di['kodedata'] ])}}')" class="btn btn-xs btn-warning">
												<i class="fa fa-pen"> </i> PROGRES
											</button>
										</div>
									</td>
									@endif
									<td>
										{!!nl2br($d->capaian)!!}
									</td>
									<td>

										@if($d->progress==100)
										<p><i class="fa fa-check text-success"></i> 										{{number_format($d->progress)}} %</p>
										@else
																				{{number_format($d->progress)}} %
										@endif
									</td>
									@if(!isset($editable))
									
									<td>
										
									</td>
									@endif
									<td>
										
									</td>
									<td>
										
									</td>
									<td>

									</td>


								</tr>
								@foreach($d->outcome as $c)
									@php
									$di=HPV::rkpd_nes($c);
									@endphp
									<tr data-tt-id="{{$di['id']}}"  data-tt-parent-id="{{$di['parent']}}" >
										<td></td>
										<td></td>
										<td></td>

										<td scope="row">{{$di['jenis']}}</td>
										<td>{{$di['kode']}}</td>
										<td>
											
											<p style="margin-left:20px;"><i  >{!!HPV::c_icon(2).' '.$di['uraian']!!}</i></p>
										</td>
										<td>Rp. {{number_format($di['pagu'])}}</td>

										<td>{{$di['target']}}</td>
										<td>{{$di['satuan']}}</td>
										<td>
										
									</td>
									<td>
										
									</td>
									<td>
										
									</td>
									<td></td>
									<td></td>


								</tr>
								@endforeach
								@foreach($d->kegiatan as $k)
									@php
									$di=HPV::rkpd_nes($k);
									@endphp
									<tr class="bg-success" data-tt-id="{{$di['id']}}"  data-tt-parent-id="{{$di['parent']}}" >
										
										<td></td>
										<td></td>
										<td></td>
										<td scope="row">{{$di['jenis']}}</td>
										<td>{{$di['kode']}}</td>
										<td>
										<p style="margin-left:20px;"><i  >{!!HPV::c_icon(3).' '.$di['uraian']!!}</i></p>
										</td>
										<td>Rp. {{number_format($di['pagu'])}}</td>

										<td>{{$di['target']}}</td>
										<td>{{$di['satuan']}}</td>
											<td>
										
									</td>
									<td>
										
									</td>
									<td>
									</td>
									@if(!isset($editable))
									<td>
										<div class="btn-group">
											<button class="btn btn-xs btn-warning">
												<i class="fa fa-pen"> </i> PERMASALHAN
											</button>
										</div>
									</td>
									@endif
									<td>
										
									</td>
									<td></td>
									<td>
										@if(!isset($editable))
										@can('accessPusat')
										<div class="btn-group">
											<button class="btn btn-xs btn-warning">
												<i class="fa fa-pen"> </i> REKOMENDASI
											</button>
										</div>
										@endcan
										@endif
										<p></p>

									</td>


								</tr>
								@foreach($k->output as $i)
										@php
										$di=HPV::rkpd_nes($i);
										@endphp
										<tr data-tt-id="{{$di['id']}}"  data-tt-parent-id="{{$di['parent']}}" >
											
											<td></td>
											<td></td>
											<td></td>
											<td scope="row">{{$di['jenis']}}</td>
											<td>{{$di['kode']}}</td>
											<td>
												<p style="margin-left:40px;"><i >{!!HPV::c_icon(4).' '.$di['uraian']!!}</i></p>
											</td>
											<td>Rp. {{number_format($di['pagu'])}}</td>

											<td>{{$di['target']}}</td>
											<td>{{$di['satuan']}}</td>
											<td>
										
									</td>
									<td>
									</td>
									<td>
										
									</td>
									<td></td>
									<td></td>


									</tr>
									@endforeach
								@endforeach

							@endforeach
						</tbody>
					</table>

					<script type="text/javascript">
						setTimeout(function(){
							$('#treetable-init-{{$dom_id_rkpd_detail}}').treetable({ expandable: true,column:3,initialState:'expanded' });
						},500);
					</script>