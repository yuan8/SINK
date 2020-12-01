@extends('adminlte::dashboard')


@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_'.$pemda->id.'.js')}}"></script>
@stop


@section('content')
<h1 class="text-center"><b>IMPLEMENTASI KEBIJAKAN PUSAT - {{$pemda->nama}} </b></h1>
<p class="text-center">PEMETAAN TAHUN {{$GLOBALS['tahun_access']}}</p>
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

<div class="box box-solid">
	<div class="box-body table-responsive" >
		<table class="table table-bordered datatable-init " >
			<thead>
				<tr>
					<th style="max-width: 20px;">ACTION</th>

					<th style="max-width: 30px;">KODE PEMDA</th>
					<th>NAMA PEMDA</th>
					<th style="max-width: 60px;">PERSENTASE IMPLEMENTASI MANDAT PEMDA</th>
					<th style="max-width: 60px;">PERSENTASE IMPLEMENTASI MANDAT PEMDA (SESUAI)</th>
					<th>PROVINSI MENGIMPLEMENTASI KEBIJAKAN</th>
					<th>JUMLAH IMPLEMENTASI MANDAT REGULASI </th>
					<th>JUMLAH IMPLEMENTASI MANDAT REGULASI  (SESUAI)</th>
					<th>JUMLAH IMPLEMENTASI MANDAT KEGIATAN </th>
					<th>JUMLAH IMPLEMENTASI MANDAT KEGIATAN  (SESUAI)</th>


				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td scope="row">
							<div class="btn-group-vertical">
								<a href="{{route('d.kebijakan.detail',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-primary btn-xs">Detail</a>
							
							</div>

						</td>
						<td ><b>{{$d->id}}</b></td>
						<td><b>{{$d->name}}</b></td>
						<td style="background:{{$d->color_implemented}}; {{in_array($d->color_implemented,['black','red','green'])?'color:#fff;':''}}">
							<b>{{number_format($d->implemented_count,1)}}%</b>
						</td>
						<td style="background:{{$d->color}}; {{in_array($d->color,['black','red','green'])?'color:#fff;':''}}"><b>{{number_format($d->value,1)}}%</b></td>
						<td>{{$d->pemda_implemented?'IMPLEMENTED':'BELUM'}}</td>

						<td>{{number_format($d->jumlah_mandat_regulasi)}} Mandat</td>
						<td>{{number_format($d->jumlah_mandat_regulasi_sesuai)}}  Mandat </td>
						<td>{{number_format($d->jumlah_mandat_kegiatan)}} Mandat</td>
						<td>{{number_format($d->jumlah_mandat_kegiatan_sesuai)}}  Mandat</td>
						





					</tr>
				@endforeach
				
			</tbody>
		</table>
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
                    text: 'IMPLEMENTASI SESUAI KEBIJAKAN  PUSAT - {{$pemda->nama}} ',
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
					    name: 'KEBIJAKAN NASIONAL',
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
        text: 'IMPLEMENTASI KEBIJAKAN  PUSAT - {{$pemda->nama}}'
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
        name: 'PEMDA MENGIMPLEMENTASI MANDAT REGULASI',
        color:'#00c0ef',
        data: <?=json_encode($data_chart['regulasi'])?>
    },
    {
        name: 'PEMDA SESUAI MENGIMPLEMENTASI MANDAT REGULASI ',
        color:'#93eaff',
        data: <?=json_encode($data_chart['regulasi_sesuai'])?>
    },
    {
        name: 'PEMDA MENGIMPLEMENTASI MANDAT KEGIATAN',
        color:'#00a65a',
        data: <?=json_encode($data_chart['kegiatan'])?>
    },
    {
        name: 'PEMDA SESUAI MENGIMPLEMENTASI MANDAT KEGIATAN ',
        color:'#83ffc6',
        data: <?=json_encode($data_chart['kegiatan_sesuai'])?>
    },

    ]
});
</script>

@stop