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
				<div class="box-body table-responsive">
					<table class="table table-bordered" id="treetable-init">
						<thead>
							<tr>
								<th>SUB URUSAN</th>
								<th>MANDAT</th>
								<th>JENIS</th>

								
								<th>UNDANG-UNDANG</th>
							

								<th>PERATURAN PEMERINTAH</th>
								
								<th>PERATURAN PRESINDEN</th>
								<th>PERATURAN MENTRI</th>
							

								
							</tr>
						</thead>
						<tbody>
							@php
								$id_urusan=0;
							@endphp
							@foreach($data as $d)
							@if($id_urusan!=$d->id_urusan)
							<tr>
								<td class="bg-info" colspan="7">
									<p><b>{{$d->nama_urusan}}</b></p>
								</td>
							</tr>
							@php
								$id_urusan=$d->id_urusan;
							@endphp
							@endif
								<tr data-tt-id="mandat_{{$d->id}}">
									<td>{{$d->nama_sub_urusan}}</td>
									
									<td><span>{!!nl2br($d->uraian)!!} ({{number_format($d->child_count)}})</span>
									</td>
									<td class="{{$d->jenis=='REGULASI'?'bg-info':'bg-success'}}">
										{{$d->jenis}}
									</td>
									<td >
										
									</td>
									<td>
										
									</td>
									<td >
										
									</td>
									<td>
										
									</td>
								
								</tr>
									@for($i=0;$i<$d->child_count;$i++)

									<tr data-tt-parent-id="mandat_{{$d->id}}" data-tt-id="kb_{{$d->id}}_{{$i}}" >
										
										<td>
											
										</td>

										<td style="min-width: 200px;">
											<span>{!!HPV::c_icon(1)!!} REGULASI</span>
										</td>
										<td></td>
								
										<td>
											@isset($d->uu[$i])
											{{$i+1}}. {!! nl2br($d->uu[$i]->jenis.'/'.$d->uu[$i]->tahun_berlaku.' - '.$d->uu[$i]->uraian)!!}
											@endisset
										</td>
							
										<td>
											@isset($d->pp[$i])
												{{$i+1}}. {!! nl2br($d->pp[$i]->jenis.'/'.$d->pp[$i]->tahun_berlaku.' - '.$d->pp[$i]->uraian)!!}
											@endisset
										</td>
											<td>
											@isset($d->perpres[$i])
												{{$i+1}}. {!! nl2br($d->perpres[$i]->jenis.'/'.$d->perpres[$i]->tahun_berlaku.' - '.$d->perpres[$i]->uraian)!!}
											@endisset
										</td>
									
										<td>
											@isset($d->permen[$i])
												{{$i+1}}. {!! nl2br($d->permen[$i]->jenis.'/'.$d->permen[$i]->tahun_berlaku.' - '.$d->permen[$i]->uraian)!!}
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
<script type="text/javascript">
	$('.init-select-2').select2();
	$('#treetable-init').treetable({ expandable: true,column:1,initialState:'expanded' });

	Highcharts.chart('chart-mandat', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'KEBIJAKAN PUSAT (MANDAT)'
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
            text: 'JUMLAH REGULASI'
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
        name: 'UU',
        data: <?= json_encode($data_chart['uu']) ?>

    }, 
      {
        name: 'PP',
        data: <?= json_encode($data_chart['pp']) ?>

    }, 
      {
        name: 'PERPRES',
        data: <?= json_encode($data_chart['perpres']) ?>

    }, 
      {
        name: 'PERMEN',
        data: <?= json_encode($data_chart['permen']) ?>

    }, 

    ]
});
	

</script>
@stop