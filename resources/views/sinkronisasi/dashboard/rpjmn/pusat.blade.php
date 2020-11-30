@extends('adminlte::dashboard')

@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

@stop


@section('content')
<div class="row" style="margin-bottom: 10px;">
	<form action="{{url()->current()}}" method="get" id="form-f">
			
		<div class="col-md-12">
			<label>URUSAN</label>
			<select class="form-control init-select-2" multiple="" name="urusan[]" onchange="$('#form-f').submit()">
				@foreach($list_urusan as $su)
				<option value="{{$su->id}}" {{in_array($su->id,$req->urusan)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
		</div>
	</form>
		
	</div>
	<div class="row">
		<div class="col-md-12" id="chart-mandat"></div>
	</div>
<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body table-responsive" style="max-height: 500px;">
					<table class="table table-bordered sticky-table" id="treetable-init">
						<thead>
							<tr>
								<th colspan="3">PEMETAAN</th>
								<th colspan="10">INDIKATOR</th>

							</tr>
							<tr>
								
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
								@php
								$id_urusan=0;
							@endphp

							@foreach($data as $d)
							@if($id_urusan!=$d->id_urusan)
							<tr>
								<td scope="row" class="bg-info" colspan="12">
									<p><b>{{$d->nama_urusan}}</b></p>
								</td>
							</tr>
							@php
								$id_urusan=$d->id_urusan;
							@endphp
							@endif
								<tr data-tt-id="KONDISI_{{$d->id}}">
									
									<td scope="row" >{{$d->jenis}}</td>
						
									<td>{{$d->uraian}}</td>
									<td>{!!nl2br($d->keterangan)!!}</td>
									<td colspan="10"></td>




								</tr>
								@foreach($d->isu as $isu)
									<tr data-tt-parent-id="KONDISI_{{$d->id}}" data-tt-id="ISU_{{$isu->id}}">
										
										<td scope="row" >{{$isu->jenis}}</td>
									
										<td>{{$isu->uraian}}</td>
										<td>{!!nl2br($isu->keterangan)!!}</td>
										<td colspan="10"></td>





									</tr>
									@foreach($isu->arah_kebijakan as $kb)
										<tr data-tt-parent-id="ISU_{{$kb->id_parent}}" data-tt-id="KEBIJAKAN_{{$kb->id}}">
											
											<td scope="row">{{$kb->jenis}}</td>
											
											<td>{{$kb->uraian}}</td>
											<td>{!!nl2br($kb->keterangan)!!}</td>
											<td colspan="10"></td>
											
											@foreach($kb->indikator as $i)


												<tr data-tt-parent-id="KEBIJAKAN_{{$i->id_rpjmn}}" data-tt-id="INDIKATOR_{{$i->id}}">
													
													<td scope="row">INDIKATOR ARAH KEBIJAKAN</td>

													<td></td>
													<td></td>
													<td>
														
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
	</div>
	
@stop
@section('js')
<script type="text/javascript">
	$('.init-select-2').select2();
	$('#treetable-init').treetable({ expandable: true,column:0,initialState:'expanded' });

	Highcharts.chart('chart-mandat', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'JUMLAH INDIKATOR PEMETAAN  ARAH KEBIJAKAN'
    },
    subtitle: {
        text: 'PEMETAAN {{$GLOBALS['tahun_access']}}'
    },
    xAxis: {
        type: "category",
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'JUMLAH INDIKATOR'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} Regulasi</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    series: [
    {
        name: 'JUMLAH INDIKATOR',
        data: <?= json_encode($data_chart) ?>

    },
     

    ]
});
	

</script>
@stop