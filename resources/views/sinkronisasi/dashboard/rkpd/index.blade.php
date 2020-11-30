@extends('adminlte::dashboard')


@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
@stop


@section('content')
<h1 class="text-center"><b>PEMDA MELAPORKAN RKPD {{$GLOBALS['tahun_access']}}</b></h1>
<hr>

<div class="container-fluid" style="margin-bottom: 10px;">
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
<div class="row" style="margin-bottom: 15px;">


	<div class="col-md-6" id="chart" style="background: #fff; height: 462px;">

	</div>
	<div class="col-md-6"  style="background: #fff;  height: 462px;">
		<div id="map"></div>
		<p class="text-center"><b>Persentase Pelaporan</b></p>
		<ul class="list-group list-group-horizontal text-center">
		  <li class="list-group-item"><i class="fas fa-circle"></i> =0%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:red;"></i> <=20%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:orange;"></i> <=40%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:yellow;"> </i> <=60%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:green;"> </i> <=60%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:#45ff23;"> </i> <=100%</li>
		</ul>
	</div>

</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
					<table class="table table-bordered datatable-init" >
						<thead>
							<tr>
								<th>KODEPEMDA</th>
								<th>NAMA PEMDA</th>
								<th>JUMLAH PEMDA</th>
								<th>JUMLAH PEMDA MELAPOR</th>
								<th>PERSENTASE PELAPORAN PEMDA</th>
								<th>PROVINSI MELAPORKAN RKPD</th>
								<th>PAGU RKPD PROVINSI </th>

								<th>JUMLAH PROGRAM PROVINSI</th>
								<th>JUMLAH KEGIATAN PROVINSI</th>
								<th>ACTION</th>

							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr>
									<td><b>{{$d->id}}</b></td>
									<td><b>{{$d->name}}</b></td>
									<td>{{$d->jumlah_pemda}} PEMDA</td>
									<td>{{$d->jumlah_pemda_melapor}} PEMDA</td>
									<td style="background:{{$d->color}}; {{in_array($d->color,['black','red','green'])?'color:#fff;':''}}"><b>{{number_format($d->value,1)}}%</b></td>
									<td>{{$d->provinsi_melapor?'MELAPOR':'TIDAK'}}</td>
									<td>Rp. {{number_format($d->jumlah_pagu)}} </td>

									<td>{{number_format($d->jumlah_program)}} Program</td>
									<td>{{number_format($d->jumlah_kegiatan)}} Kegiatan</td>
									<td>
										<div class="btn-group-vertical">
											<a href="{{route('d.rkpd.detail',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-primary btn-xs">Detail RKPD Provinsi</a>
										<a href="{{route('d.rkpd.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-success btn-xs">Detail Pemda</a>
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
	$('.datatable-init').dataTable();


		map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'PELAPORAN RKPD PER-PROVINSI',
                    style:{
                        color:'#222'
                    },
                    enabled:false
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
					      events:{
		                	click:function(e){
		                		window.location.href=e.point.link??'#';
		                	}
		                },
					    name: 'RKPD NASIONAL',
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
					}

                ]

            });




// ------


Highcharts.chart('chart', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'PELAPORAN RKPD PER-PROVINSI'
    },
    xAxis: {
        type: "category"
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
        name: 'PEMDA MELAPOR',
        color:'green',
        data: <?=json_encode($data_chart['melapor'])?>
    },
    {
        name: 'PEMDA TIDAK MELAPOR',
        color:'red',
        data: <?=json_encode($data_chart['tidak_melapor'])?>
    }]
});
</script>

@stop