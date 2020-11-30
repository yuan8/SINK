@extends('adminlte::dashboard')


@section('content_header')
    
@stop


@section('content')
<div class="row">


	<div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h4>DASHBOARD</h4>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-speedometer"></i>
        </div>
        <a href="{{route('index',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
	
	@can('accessPusat')
  <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h4>PEMETAAN PUSAT</h4>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-merge"></i>
        </div>
        
        <a href="{{route('sink.pusat.index',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  @endcan

    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h4>PEMETAAN DAERAH</h4>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-pull-request"></i>
        </div>
        <a href="{{route('sink.daerah.init',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>


   @can('accessAdmin')
     <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-maroon">
        <div class="inner">
          <h4>SUPERADMIN</h4>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-settings"></i>
        </div>
        <a href="{{route('sink.admin.index',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

   @endcan

</div>

@stop