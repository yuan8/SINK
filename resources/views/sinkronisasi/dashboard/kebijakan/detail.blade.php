@extends('adminlte::dashboard')

@section('content_header')
    <h1 class="text-center"><B>IMPLEMENTASI KEBIJAKAN PUSAT - {{$pemda->nama}}</B> </h1>
    <p class="text-center">PEMETAAN TAHUN {{$GLOBALS['tahun_access']}}</p>
<hr>

@stop


@section('content')
<div class="row" style="margin-bottom: 10px;">
	<form action="{{url()->current()}}" method="get" id="form-f">
			
		<div class="col-md-12">
			<label>URUSAN</label>
			<select class="form-control init-select-2"  name="urusan[]" onchange="$('#form-f').submit()">
				@foreach($list_urusan as $su)
				<option value="{{$su->id}}" {{in_array($su->id,$req->urusan)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
		</div>
	</form>
		
	</div>

<div class="box box-solid">
	<div class="box-header with-border">
					<div class="btn-group">
						<button class="btn btn-success btn-sm" onclick="EXPORT_EXCEL('#treetable-init','DATA IMPLEMENTASI MENDAT TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT EXCEL<i class="fa fa-excel"></i></button>
					<button class="btn btn-primary btn-sm" onclick="EXPORT_PDF('#treetable-init','DATA IMPLEMENTASI MENDAT  TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT PDF<i class="fa fa-pdf"></i></button>
					</div>
				</div>
				<div class="box-body table-responsive">
					<table class="table table-bordered datatable-auto" id="treetable-init">
						<thead>
							<tr>
								<th>SUB URUSAN</th>
								<th>JENIS REGULASI</th>
								<th>URAIAN</th>
								<th>PENILAIAN KESESUAIAN</th>
								<th>CATATAN</th>
							</tr>
						</thead>
						<tbody>
							@php
								$id_urusan=0;
							@endphp
							@foreach($data as $m)
							@if($id_urusan!=$m->id_urusan)
							<tr>
								<td class="bg-info" colspan="5">
									<p><b>{{$m->nama_urusan}}</b></p>
								</td>
							</tr>
							@php
								$id_urusan=$m->id_urusan;
							@endphp
							@endif
								<tr data-tt-id="MANDAT_{{$m->id}}">
									<td>{{$m->nama_sub_urusan}}</td>
									<td>MANDAT PUSAT ({{count(($m->penilaian?$m->penilaian->kb:[]))}})</td>
									
									<td>
										<p><i>"{!!nl2br($m->uraian)!!}"</i></p>
										<br>
										<p><b>REGULASI PUSAT</b></p>
										<br>
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
@stop

@section('js')
<script type="text/javascript">
	$('.init-select-2').select2();

	
	$('#treetable-init').treetable({ expandable: true,column:1,initialState:'expanded' });

	

</script>
@stop