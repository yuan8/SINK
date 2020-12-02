@extends('adminlte::dashboard')

@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>
  @if($req->provinsi)
  	<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_'.$provinsi->id.'.js')}}"></script>

  @else
  	<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>

  	<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
  @endif
  <style type="text/css">
	.list-group-horizontal .list-group-item
{
	display: inline-block;
}
.list-group-horizontal .list-group-item
{
	margin-bottom: 0;
	margin-left:-4px;
	margin-right: 0;
 	border-right-width: 0;
}
.list-group-horizontal .list-group-item:first-child
{
	border-top-right-radius:0;
	border-bottom-left-radius:4px;
}
.list-group-horizontal .list-group-item:last-child
{
	border-top-right-radius:4px;
	border-bottom-left-radius:0;
	border-right-width: 1px;
}
</style>
<h1 class="text-center"><b>STATUS DATA RKPD TAHUN {{$GLOBALS['tahun_access']}}</b></h1>
@if($req->provinsi)
	<p class="text-center">{{$provinsi->nama}}</p>
@endif
<hr>
@stop


@section('content')
<div class="row" style="margin-bottom: 10px;">
	<form action="{{url()->current()}}" method="get" id="form-f">
			
		<div class="col-md-6">
			<label>URUSAN</label>
			<select class="form-control init-select-2"  name="urusan[]" onchange="$('#form-f').submit()">
				<option value="">-</option>
				@foreach($list_urusan as $su)
				<option value="{{$su->id}}" {{in_array($su->id,$req->urusan)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
		</div>
		<div class="col-md-6">
			<label>PROVINSI</label>
			<select class="form-control init-select-2"  name="provinsi" onchange="$('#form-f').submit()">
				<option value="">-</option>

				@foreach($list_provinsi as $su)
				<option value="{{$su->id}}" {{($su->id==$req->provinsi)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
		</div>
	</form>
		
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">
				<table class="table table-bordered export-auto" >
					<thead>
						<tr>
							<th>TOTAL PEMDA</th>
							<th>DATA RKPD</th>
							<th>RKPD FINAL</th>
							<th>RKPD BELUM FINAL</th>
							@if(!$req->urusan)
							<th>RKPD TERPETAKAN (BELUM LENGKAP)</th>
							@endif
							<th>RKPD TERPETAKAN {{!$req->urusan?'LENGKAP':''}}</th>
						</tr>
					</thead>
					<tbody>
						@if(!$req->provinsi)
						<tr class="bg-primary">
							<td colspan="6"><b>REKAP RKPD PROVINSI</b></td>
						</tr>
						<tr >
							<td>
								{{$meta['PROVINSI']['jumlah_pemda']}} PEMDA
							</td>
							<td>
								{{$meta['PROVINSI']['jumlah_pemda_melapor']}} PEMDA
							</td>
							<td>
								{{$meta['PROVINSI']['jumlah_pemda_final']}} PEMDA
							</td>
							<td>
								{{$meta['PROVINSI']['jumlah_pemda_belum_final']}} PEMDA
							</td>
							@if(!$req->urusan)

							<td>
								{{$meta['PROVINSI']['jumlah_pemda_terpetakan']}} PEMDA
							</td>
							@endif
							<td>
								{{$meta['PROVINSI']['jumlah_pemda_terpetakan_lengkap']}} PEMDA
							</td>
							
						</tr>
						<tr class="bg-green">
							<td colspan="6"><b>REKAP RKPD KOTA</b></td>
						</tr>
						@endif
						<tr >
							<td>
								{{$meta['KOTA']['jumlah_pemda']}} PEMDA
							</td>
							<td>
								{{$meta['KOTA']['jumlah_pemda_melapor']}} PEMDA
							</td>
							<td>
								{{$meta['KOTA']['jumlah_pemda_final']}} PEMDA
							</td>
							<td>
								{{$meta['KOTA']['jumlah_pemda_belum_final']}} PEMDA
							</td>
							@if(!$req->urusan)

							<td>
								{{$meta['KOTA']['jumlah_pemda_terpetakan']}} PEMDA
							</td>
							@endif

							<td>
								{{$meta['KOTA']['jumlah_pemda_terpetakan_lengkap']}} PEMDA
							</td>
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
	<div class="{{!isset($req->provinsi)?'col-md-12':'col-md-8'}}"  style="background: #fff;  height: 462px; margin-bottom: 20px;" >
	<div id="map"></div>
	<p class="text-center"><b>STATUS RKPD PEMDA</b></p>
	<ul class="list-group list-group-horizontal text-center">
	  <li class="list-group-item"><i class="fas fa-circle"></i> TIDAK ADA ADA</li>
	  <li class="list-group-item"><i class="fas fa-circle" style="color:red;"></i> BELUM FINAL </li>
	
	  <li class="list-group-item"><i class="fas fa-circle" style="color:yellow;"> </i> BELUM  TERPETAKAN</li>
	  @if(!$req->urusan)

	  <li class="list-group-item"><i class="fas fa-circle" style="color:green;"> </i> TERPETAKAN</li>
	  @endif
	  <li class="list-group-item"><i class="fas fa-circle" style="color:#45ff23;"> </i> TERPETAKAN {{!$req->urusan?'LENGKAP':''}}</li>
	</ul>
</div>
@php
@endphp
@if($provinsi)
<div class="col-md-4" id="chart-persentase" style="background: #e7ffe7;  height: 462px; margin-bottom: 20px;" >
</div>
@endif


<div class="row">
		<div class="col-md-12">
			<div class="box box">
				<div class="box-header with-border">
					<div class="btn-group">
						<button class="btn btn-success btn-sm" onclick="EXPORT_EXCEL('#treetable-init','DATA RKPD PEMDA {{$provinsi?$provinsi->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT EXCEL<i class="fa fa-excel"></i></button>
					<button class="btn btn-primary btn-sm" onclick="EXPORT_PDF('#treetable-init','DATA RKPD PEMDA {{$provinsi?$provinsi->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT PDF<i class="fa fa-pdf"></i></button>
					</div>
				</div>
				<div class="box-body table-responsive Flipped">
					<table data-page-length="548" class="table table-bordered sticky-table export-auto datatable-auto" id="treetable-init">
						<thead>
							<tr data-tableexport-display="none">
								<th colspan="10">INFORMASI RKPD</th>
								<th colspan="{{COUNT($urusan)}}">INFORMASI PEMETAAN URUSAN</th>

							</tr>
							<tr>
								<th data-tableexport-display="none"  >AKSI</th>
								<th>KODEPEMDA</th>
								<th>NAMA PEMDA</th>
								<th>STATUS DATA</th>
								<th>NOMENKLATUR</th>
								<th>PERKADA</th>
								<th>UPDATE DATA</th>
								<th data-tableexport-display="none">PAGU</th>

								<th>JUMLAH PROGRAM</th>
								<th>JUMLAH KEGIATAN</th>
								<th>PAGU PEMETAAN</th>

								@foreach($urusan as $u)
								<th>{{$u->nama}}</th>
								@endforeach
								
							</tr>
							<tr data-tableexport-display="none">
								<th data-orderable="false" >1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
								<th>5</th>
								<th>6</th>
								<th>7</th>
								<th>8</th>

								<th>9</th>
								<th>10</th>
								<th>11</th>

								@foreach($urusan as $key=>$u)
								<th>{{12+$key}}</th>
								@endforeach


							</tr>
						</thead>
						<tbody>
							@foreach($table as $d)
								<tr>
									<td data-tableexport-display="none" scope="row">
										<div class="btn-group-vertical">
											<a href="{{route('d.rkpd.detail',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-primary btn-xs">Detail RKPD Provinsi</a>
											<a href="{{route('d.rkpd.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-success btn-xs">Detail Pemda</a>
										</div>
									</td>
									<td>{{$d->id}}</td>
									<td scope="row" style="left:100px;">{{$d->name}}</td>
									<td>{{HPV::status_rkpd($d->status)}}</td>
									<td>{!!$d->nomenklatur!!}</td>
									<td>{!!$d->perkada!!}</td>
									<td>{!!YT::parse($d->last_date)->format('d F Y')!!}</td>
									<td data-tableexport-display="none">
										<ul>
											<li>PAGU LAPORAN : Rp. {{number_format($d->pagu_data)}} </li>
											<li>PAGU KALULASI : Rp. {{number_format($d->pagu_pelaporan)}} </li>
											
										</ul>
									</td>
									<td>
										{{number_format($d->jumlah_program)}}
									</td>
									<td>
										{{number_format($d->jumlah_kegiatan)}}
									</td>
									<td>Rp. {{number_format($d->pagu_pemetaan)}}</td>
									@foreach($urusan as $u)
								
									<td>
										@if(in_array($u->nama,explode('|',$d->list_nama_urusan)))
											<i class="fa fa-check text-success"></i> SUDAH TERPETAKAN
										@else
											<i class="fa fa-times text-danger"></i> BELUM TERPETAKAN

										@endif

									</td>
									@endforeach




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

@if($req->provinsi)
@php
	$persentase=[
		'belum_terpetakan'=>0,
		'terpetakan_lengkap'=>0,
		'terpetakan'=>0,


	];

	if($meta['KOTA']['jumlah_pemda_final']){
		$persentase['belum_terpetakan']=(($meta['KOTA']['jumlah_pemda_final']+$meta['KOTA']['jumlah_pemda_belum_final'])/$meta['KOTA']['jumlah_pemda'])*100;
	}

	if($meta['KOTA']['jumlah_pemda_terpetakan']){
		$persentase['terpetakan']=($meta['KOTA']['jumlah_pemda_terpetakan']/$meta['KOTA']['jumlah_pemda'])*100;
	}

	if($meta['KOTA']['jumlah_pemda_terpetakan_lengkap']){
		$persentase['terpetakan_lengkap']=($meta['KOTA']['jumlah_pemda_terpetakan_lengkap']/$meta['KOTA']['jumlah_pemda'])*100;
	}

@endphp
Highcharts.chart('chart-persentase', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
        backgroundColor:'transparent'
    },
    title: {
        text: 'RKPD PEMDA {{$provinsi->nama}} TAHUN {{$GLOBALS['tahun_access']}}'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    subtitle:{
    	text:'{{$req_urusan?$req_urusan->nama:''}}'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            enabled:true,
            showInLegend: true,
            dataLabels: {
		        enabled: true,
		        format: '{point.percentage:.1f}%',
		        color: '#fff',
		        style: {
		            fontSize: 9,
		            font: '9px Trebuchet MS, Verdana, sans-serif'
		        },
		    },
        }
    },
    series: [{
        name: 'Persentase',
        colorByPoint: true,
        data: [{
            name: 'RKPD BELUM TERPETAKAN',
            y: {{$persentase['belum_terpetakan']}},
            sliced: true,
            selected: true,
        }, {
            name: 'RKP TERPETAKAN SEBAGIAN',
            y: {{$persentase['terpetakan']}},


        }, {
            name: 'RKPD TERPETAKAN LENGKAP',
            y: {{$persentase['terpetakan_lengkap']}},
            color:'#45ff23'
        }]
    }]
});

@endif

		map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                   subtitle:{
    	text:'{{$req_urusan?$req_urusan->nama:''}}'
    },
                title: {
                    text: 'STATUS RKPD PEMDA {{$provinsi?$provinsi->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}',
                    style:{ 
                        color:'#222'
                    },
                    enabled:false
                },

                legend: {
                    enabled: true
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    headerFormat: '',
                    formatter: function() {
                        return (this.point.tooltip == undefined ? (this.point.integrasi !== undefined ? this.point.integrasi : this.point.nama) : this.point.tooltip);
                    }
                },

                 mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },
                series:[
                	@if(!$req->provinsi)
                	{
					    data: <?= json_encode($data['PROVINSI']) ?>,
					      events:{
		                	click:function(e){
		                		window.location.href=e.point.link??'#';
		                	}
		                },
					    name: 'RKPD PROVINSI',
					    joinBy: 'id',
					    type:'map',
					    visible:true,
					    mapData:Highcharts.maps['ind'],
					    dataLabels: {
					        enabled: true,
					        format: '{point.name}',
					        color: '#fff',
					        style: {
					            fontSize: 9,
					            font: '9px Trebuchet MS, Verdana, sans-serif'
					        },
					    },
					    color:'{point.color}',
					    states: {
					        hover: {
					            color: '#BADA55'
					        }
					    },
					},
                	@endif
                	{
					    data: <?= json_encode($data['KOTA']) ?>,
					      events:{
		                	click:function(e){
		                		window.location.href=e.point.link??'#';
		                	}
		                },
					    name: 'RKPD KOTA KABUPATEN',
					    joinBy: 'id',
					    type:'map',
					    visible:{{!$req->provinsi?'false':'true'}},
					    mapData:Highcharts.maps['{{!$req->provinsi?'ind_kota':'idn_'.$provinsi->id}}'],
					    dataLabels: {
					        enabled: false,
					        format: '{point.name}',
					        color: '#fff',
					        style: {
					            fontSize: 9,
					            font: '9px Trebuchet MS, Verdana, sans-serif'
					        },
					    },
					    color:'{point.color}',
					    states: {
					        hover: {
					            color: '#BADA55'
					        }
					    },
					},
					

                ]

            });
	

</script>
@stop