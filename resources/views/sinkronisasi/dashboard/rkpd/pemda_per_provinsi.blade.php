@extends('adminlte::dashboard')


@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_'.$pemda->id.'.js')}}"></script>
<h1 class="text-center"><b>PELAPORAN RKPD {{$pemda->nama}} TAHUN {{$GLOBALS['tahun_access']}}</b></h1>
<hr>
@stop


@section('content')


	<form action="{{url()->current()}}" method="get" id="form-f" style="margin-bottom: 10px;">
			
		<div class="row">
			<div class="col-md-12">
			<label>URUSAN</label>
			<select class="form-control init-select-2"  name="urusan[]" onchange="$('#form-f').submit()">
				<option value="">-</option>
				@foreach($list_urusan as $su)
				<option value="{{$su->id}}" {{in_array($su->id,$req->urusan)?'selected':''}}>{{$su->nama}}</option>
				@endforeach

			</select>
		</div>
		</div>
	</form>
		
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


	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6" id="chart" style="background: #fff; height: 462px;">
			</div>
	<div class="col-md-6"  style="background: #fff;  height: 462px;">
		<div id="map"></div>
		<p class="text-center"><b>STATUS PEMETAAN RKPD</b></p>
		<ul class="list-group list-group-horizontal text-center">
		  <li class="list-group-item"><i class="fas fa-circle"></i> = BELUM TERPETAKAN</li>
		 
		  <li class="list-group-item"><i class="fas fa-circle" style="color:#45ff23;"> </i> = TERPETAKAN</li>
		</ul>
	</div>
		</div>
	</div>

	<div class="row" style="margin-top: 40px;">
		<div class="col-md-12">
			<div class="box box-success">
				<div class="box-header">
					<div class="btn-group">
					<button class="btn btn-success btn-sm" onclick="EXPORT_EXCEL('#treetable-init','DATA RKPD PEMDA {{$pemda?$pemda->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT EXCEL<i class="fa fa-excel"></i></button>
					<button class="btn btn-primary btn-sm" onclick="EXPORT_PDF('#treetable-init','DATA RKPD PEMDA {{$pemda?$pemda->nama:''}} TAHUN {{$GLOBALS['tahun_access']}}')">EXPORT PDF<i class="fa fa-pdf"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table  data-page-length="548" class="table table-bordered datatable-auto" id="treetable-init">
						<thead>
							<tr>
								<th>KODEPEMDA</th>
								<th>NAMA PEMDA</th>
								<th>STATUS RKPD</th>
								<th>STATUS PEMATAAN RKPD</th>
								<th>NOMENKLATUR</th>
								<th>PERKADA</th>

								<th>PAGU PEMETAAN RKPD</th>

								<th>JUMLAH PROGRAM </th>
								<th>JUMLAH KEGIATAN </th>
								<th data-tableexport-display="none">ACTION</th>

							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr>
									<td><b>{{$d->id}}</b></td>
									<td><b>{{$d->name}}</b></td>
									<td>{{HPV::status_rkpd($d->status)}}</td>
									<td>{{$d->jumlah_kegiatan?'TERPETAKAN':'BELUM TERPETAKAN'}}</td>
									<td>{!!$d->nomenklatur!!}</td>
									<td>{!!$d->perkada!!}</td>

									<td>Rp.{{number_format($d->jumlah_pagu)}}</td>
									<td>{{number_format($d->jumlah_program)}} </td>
									<td>{{number_format($d->jumlah_kegiatan)}} </td>
									<td data-tableexport-display="none">
										<div class="btn-group-vertical">
											<a href="{{route('d.rkpd.detail',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-success btn-xs">Detail RKPD </a>
										
										</div>

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
<style type="text/css">
	.highcharts-background{
		fill:transparent;
	}
</style>
<script type="text/javascript">
	$('.init-select-2').select2();


		map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'PELAPORAN RKPD {{$pemda->nama}}',
                    style:{
                        color:'#222'
                    },
                    enabled:false
                },
                subtitle:{
			    	text:'{{$req_urusan?$req_urusan->nama:''}}'
			    },

                legend: {
                    enabled: false
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

                	{
					    data: <?= json_encode($data) ?>,
					    name: 'APA AJA BOLEH',
					    joinBy: 'id',
					    type:'map',
					    visible:true,
					    mapData:Highcharts.maps['idn_{{$pemda->id}}'],
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
					}

                ]

            });




// ------


Highcharts.chart('chart', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'PELAPORAN RKPD {{$pemda->nama}}'
    },
    xAxis: {
        type: "category"
    },
     subtitle:{
			    	text:'{{$req_urusan?$req_urusan->nama:''}}'
		},
    yAxis: {
        min: 0,
        title: {
            text: 'JUMLAH PEMDA'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'JUMLAH PROGRAM',
        color:'#00c0ef',
        data: <?=json_encode($data_chart['jumlah_program'])?>
    },
    {
        name: 'JUMLAH KEGIATAN',
        color:'#00a65a',
        data: <?=json_encode($data_chart['jumlah_kegiatan'])?>
    }]
});
</script>

@stop