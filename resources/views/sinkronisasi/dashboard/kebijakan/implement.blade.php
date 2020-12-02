@extends('adminlte::dashboard')


@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<h1 class="text-center"><b>IMPLEMENTASI KEBIJAKAN PUSAT (MANDAT PEMBUATAN REGULASI) - PEMDA </b></h1>
<p class="text-center">PEMETAAN TAHUN {{$GLOBALS['tahun_access']}}</p>
<hr>
@stop


@section('content')


<div class="box box-solid">
	<div class="box-body">
		<table class="table-bordered table datatable-auto">
			<thead>
				<tr>
					<th>URUSAN</th>
					<th>SUB URUSAN</th>
					<th>MANDAT</th>
					<th>UU</th>
					<th>PP</th>
					<th>PERPRES</th>
					<th>PERMEN</th>


				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$mandat->nama_urusan}}</td>
					<td>{{$mandat->nama_sub_urusan}}</td>
					<td>{{$mandat->uraian}}</td>
					<td>
						<ol>
							@foreach($mandat->uu as $u)
								<li>{{$u->jenis}}/{{$u->tahun_berlaku}} - {{$u->uraian}}</li>
							@endforeach
						</ol>
						
					</td>
					<td>
						<ol>
							@foreach($mandat->pp as $u)
								<li>{{$u->jenis}}/{{$u->tahun_berlaku}} - {{$u->uraian}}</li>
							@endforeach
						</ol>
						
					</td>
					<td>
						<ol>
							@foreach($mandat->perpres as $u)
								<li>{{$u->jenis}}/{{$u->tahun_berlaku}} - {{$u->uraian}}</li>
							@endforeach
						</ol>
						
					</td>
					<td>
						<ol>
							@foreach($mandat->permen as $u)
								<li>{{$u->jenis}}/{{$u->tahun_berlaku}} - {{$u->uraian}}</li>
							@endforeach
						</ol>
						
					</td>



				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<p class="text-center"><b>REKAP IMPLEMENTASI MANDAT  PUSAT <i class="fa fa-arrow-right"></i> REGULASI PEMDA</b></p>
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-light-blue"><i class="fa fa-bookmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL PEMDA</span>
              <span class="info-box-number">{{$meta['jumlah_pemda_implemented']}}/{{$meta['jumlah_pemda']}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
     <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-bookmark"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL PEMDA PROVINSI</span>
              <span class="info-box-number">{{$meta['jumlah_provinsi_implemented']}}/{{$meta['jumlah_pemda_provinsi']}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">PEMDA SESUAI</span>
          <span class="info-box-number">{{$meta['jumlah_pemda_implemented_sesuai']}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-maroon"><i class="fa fa-times"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">PEMDA BELUM SESUAI</span>
          <span class="info-box-number">{{$meta['jumlah_pemda_implemented_tidak_sesuai']}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

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
		<p class="text-center"><b>Persentase Implementasi PEMDA Per Provinsi</b></p>
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
					<th>ACTION</th>

					<th style="max-width: 30px;">KODE PEMDA</th>
					<th>NAMA PEMDA</th>
					<th>JUMLAH PEMDA</th>
					<th>JUMLAH PEMDA MENGIMPLEMENTASI</th>
					<th>JUMLAH PEMDA SESUAI MENGIMPLEMENTASI</th>
					<th>JUMLAH PEMDA TIDAK SESUAI MENGIMPLEMENTASI</th>


					<th style="max-width: 60px;">PERSENTASE PEMDA IMPLEMENTASI </th>
					<th style="max-width: 60px;">PERSENTASE PEMDA IMPLEMENTASI SESUAI </th>
					<th>STATUS IMPLEMENTASI PROVINSI </th>
					

				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td scope="row">
							<div class="btn-group-vertical">
								<a href="{{route('d.kebijakan.detail',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-primary btn-xs">Detail Provinsi</a>
							<a href="{{route('d.kebijakan.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan])}}" class="btn btn-success btn-xs">Detail Pemda</a>
							</div>

						</td>
						<td ><b>{{$d->id}}</b></td>
						<td><b>{{$d->name}}</b></td>
						<td>{{$d->jumlah_pemda}} PEMDA</td>
						<td>{{$d->jumlah_pemda_implemented}} PEMDA</td>
						<td>{{$d->jumlah_mandat_pemda_sesuai}} PEMDA</td>
						<td>{{$d->jumlah_mandat_pemda_tidak_sesuai}} PEMDA</td>
						<td style="background:{{$d->color}}; {{in_array($d->color,['black','red','green'])?'color:#fff;':''}} min-width: 100px"><b>{{number_format($d->value,1)}}%</b></td>
						<td style="background:{{$d->color_sesuai}}; {{in_array($d->color_sesuai,['black','red','green'])?'color:#fff;':''}} min-width: 100px"><b>{{number_format($d->value_sesuai,1)}}%</b></td>
						<td>{{$d->provinsi_implemented?'IMPLEMENTED':'BELUM'}}</td>

						
						





					</tr>
				@endforeach
				
			</tbody>
		</table>
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
                    text: 'IMPLEMENTASI KEBIJAKAN  PUSAT - PEMDA PER-PROVINSI',
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
        text: 'IMPLEMENTASI KEBIJAKAN  PUSAT - PEMDA PER-PROVINSI'
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
            stacking: 'normal',
            
        }
    },
    series: [{
        name: 'PEMDA SESUAI DALAM MENGIMPLEMENTASI MANDAT ',
        color:'green',
        data: <?=json_encode($data_chart['sesuai'])?>
    },
    {
        name: 'PEMDA TIDAK SESUAI DALAM MENGIMPLEMENTASI MANDAT',
        color:'red',
        data: <?=json_encode($data_chart['tidak_sesuai'])?>
    }]
});
</script>

@stop