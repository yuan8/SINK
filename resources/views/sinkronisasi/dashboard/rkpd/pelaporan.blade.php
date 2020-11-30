@extends('adminlte::dashboard')

@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
  <script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
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
		<div class="col-md-12"  style="background: #fff;  height: 462px; margin-bottom: 20px;" >
		<div id="map"></div>
		<p class="text-center"><b>Persentase Pelaporan Urusan SUPD II (7 Urusan)</b></p>
		<ul class="list-group list-group-horizontal text-center">
		  <li class="list-group-item"><i class="fas fa-circle"></i> =0%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:red;"></i> <=20%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:orange;"></i> <=40%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:yellow;"> </i> <=60%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:green;"> </i> <=60%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:#45ff23;"> </i> <=100%</li>
		</ul>
	</div>

		<div class="col-md-12" id="chart-mandat"></div>


		</div>
	</div>
<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body table-responsive">
					<table class="table table-bordered" id="treetable-init">
						<thead>
							<tr>
								<th>AKSI</th>
								<th>KODEPEMDA</th>
								<th>NAMA PEMDA</th>
								<th>STATUS DATA</th>
								<th>NOMENKLATUR</th>
								<th>PERKADA</th>
								<th>UPDATE DATA</th>
								<th>PAGU</th>
								<th>JUMLAH PROGRAM</th>
								<th>JUMLAH KEGIATAN</th>
								
							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr data-tt-id="d_{{$d->kodepemda}}" {{$d->jenis_pemda=='PROVINSI'?'':'dd-tt-parent-id="d_'.$d->kode_provinsi.'"'}}>
									<td>
										<a href="{{route('d.rkpd.detail',['tahun'=>$GLOBALS['tahun_access','kodepemda'=>$d->id,'urusan'=>$req->urusan]])}}" class="btn btn-primary btn-xs">Detail</a>
									</td>
									<td>{{$d->kodepemda}}</td>
									<td>{{$d->nama_pemda}}</td>
									<td>{{$d->status}}</td>
									<td>{{$d->nomenklatur??'-'}}</td>
									<td>{!!$d->perkada??'-'!!}</td>
									<td>{!!YT::parse($d->last_date)->format('d F Y')!!}</td>
									<td>Rp. {{number_format($d->pagu_laporan)}} / 	Rp. {{number_format($d->pagu)}}</td>
									<td>{{number_format($d->jumlah_program)}} Program</td>
									<td>{{number_format($d->jumlah_kegiatan)}} Kegiatan</td>
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
	$('#treetable-init').dataTable();
	Highcharts.chart('chart-mandat', {
    chart: {
        type: 'column',
         scrollablePlotArea: {
            minWidth: 80*548,
            scrollPositionX: 1
        }
    },
    title: {
        text: 'DATA RKPD ({{$GLOBALS['tahun_access']}})'
    },
    subtitle: {
        text: 'PEMETAAN {{$GLOBALS['tahun_access']}}'
    },
    xAxis: {
        type: "category",
        crosshair: true,
     
        
    },
    yAxis: {
        // min: 0,
        title: {
            text: 'JUMLAH PROGRAM/KEGIATAN'
        },
      
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} {point.satuan}</b></td></tr>',
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
     scrollbar: {
    enabled: true
  },
    series: [
    {
        name: 'Jumlah Program',
        data: <?= json_encode($data_chart['jumlah_program']) ?>

    }, 
      {
        name: 'Jumlah Kegiatan',
        data: <?= json_encode($data_chart['jumlah_kegiatan']) ?>

    }, 
     

    ]
});


		map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'RKPD PEMETAAN URUSAN SUPD II',
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
                {
					    data: <?= json_encode($data) ?>,
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

                	{
					    data: <?= json_encode($data) ?>,
					      events:{
		                	click:function(e){
		                		window.location.href=e.point.link??'#';
		                	}
		                },
					    name: 'RKPD KOTA KABUPATEN',
					    joinBy: 'id',
					    type:'map',
					    visible:false,
					    mapData:Highcharts.maps['ind_kota'],
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