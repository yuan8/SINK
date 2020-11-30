@extends($GLOBALS['menu_access']=='P'?'adminlte::pusat':'adminlte::daerah')

@section('content_header')
    <h1>IMPLEMENTASI KEBIJAKAN REGULASI {{$GLOBALS['pemda_access']->nama_pemda}} BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>
    <div class="btn-group" style="margin-top: 10px;">
  		<a class="btn btn-primary" href='{{route('sink.daerah.kebijakan.kegiatan',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access']])}}'>LIHAT MANDAT KEGIATAN</a>
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
								<th>JENIS REGULASI</th>
								<th>AKSI REGULASI</th>
								<th>URAIAN</th>
								<th>PENILAIAN KESESUAIAN</th>
								<th>CATATAN</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $m)
								<tr data-tt-id="MANDAT_{{$m->id}}">
									<td>{{$m->nama_sub_urusan}}</td>
									<td>MANDAT PUSAT ({{count(($m->penilaian?$m->penilaian->kb:[]))}})</td>
									<td>
										<div class="btn-group">
											<button onclick="showForm('{{route('sink.daerah.kebijakan.form.add',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$m->id])}}','sm')" class="btn btn-success btn-xs">
												<i class="fa fa-plus"></i> REGULASI DAERAH
											</button>
										</div>
									</td>
									<td>
										<p><i>"{!!nl2br($m->uraian)!!}"</i></p>
										<p><b>REGULASI PUSAT</b></p>
										<ul>
											@foreach($m->uu as $uu)
											<li>{{$uu->jenis}}/{{$uu->tahun_berlaku}} - {{$uu->uraian}}</li>
											@endforeach
											@foreach($m->pp as $uu)
											<li>{{$uu->jenis}}/{{$uu->tahun_berlaku}} - {{$uu->uraian}}</li>
											@endforeach
											@foreach($m->perpres as $uu)
											<li>{{$uu->jenis}}/{{$uu->tahun_berlaku}} - {{$uu->uraian}}</li>
											@endforeach
											@foreach($m->permen as $uu)
											<li>{{$uu->jenis}}/{{$uu->tahun_berlaku}} - {{$uu->uraian}}</li>
											@endforeach
										</ul>
									</td>
									@if($m->penilaian)
										<td class="{{$m->penilaian->penilaian==2?'bg-danger':($m->penilaian->penilaian==0?'bg-warning':'')}}">
										@if(empty($m->penilaian))
											BELUM TERDAPAT DATA TURUNAN REGULASI
										@else
										<div class="btn-group">
											
											<button class="btn btn-warning btn-xs" onclick="showForm('{{route('sink.daerah.kebijakan.form.penilaian.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$m->penilaian->id])}}')"><i class="fa fa-pen"></i> PENILAIAN </button>
										</div>
										<h4><b>{!!HPV::reg_d_penilaian($m->penilaian->penilaian)!!}</b></h4>
										@endif
									</td>
									<td>
										@if(empty($m->penilaian))
											-
										@else
										{!!nl2br($m->penilaian->uraian_note)!!}

										@endif
									</td>

									@else
									<td></td>
									<td></td>


									@endif
								</tr>
								@if($m->penilaian)
									@foreach($m->penilaian->kb as $kb)
									<tr data-tt-parent-id="MANDAT_{{$m->id}}" data-tt-id="KB_{{$kb->id}}">
										<td></td>
										<td>
											<span>{!!HPV::c_icon($kb->index_kb)!!} {{$kb->jenis}}</span>
										</td>
										<td>
											<div class="btn-group">
													<button onclick="showForm('{{route('sink.daerah.kebijakan.form.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$kb->id])}}')" class="btn  btn-xs btn-danger"><i class="fa fa-trash"></i></button>
													<button onclick="showForm('{{route('sink.daerah.kebijakan.form.edit',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$kb->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>
												</div>
										</td>
										<td colspan="3">
											@if($kb->jenis=='LAINYA')
											{!!nl2br($kb->uraian)!!}
											{{'/ BERLAKU PADA TAHUN '.$kb->tahun_berlaku}}
											@else
											{!!nl2br($kb->jenis.'/'.$kb->tahun_berlaku.' - '.$kb->uraian)!!}
											@endif
										</td>
									</tr>

									@endforeach
								@endif
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