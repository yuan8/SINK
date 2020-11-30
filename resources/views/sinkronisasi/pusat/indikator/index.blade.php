@extends('adminlte::pusat')


@section('content_header')
  	 <h1 class="">INDIKATOR PUSAT  BERLAKU TAHUN {{$GLOBALS['tahun_access']}}</h1>
  	<div class="btn-group" style="margin-top: 10px;">
  		<button class="btn btn-primary" onclick="showForm('{{route('sink.pusat.indikator.create',['tahun'=>$GLOBALS['tahun_access']])}}','lg')">TAMBAH INDIKATOR</button>
  	</div>
@stop
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="datatable-init">
            <thead>
              <tr>
                <th>AKSI</th>

                <th>SUB URUSAN</th>
                <th>SUMBER DATA</th>
                <th>DUKUNGAN PUSAT</th>


                <th>KODE</th>
                <th>JENIS</th>

                <th>TOLOKUKUR</th>
                <th>JENIS NILAI</th>

                <th>TARGET PUSAT</th>

                <th>SATUAN</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $i)
                <tr>
                  <td style="min-width: 100px">
                    <div class="btn-group">
                      <button class="btn  btn-xs btn-danger" onclick="showForm('{{route('sink.pusat.indikator.form.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')"><i class="fa fa-trash"></i></button>
                      <button onclick="showForm('{{route('sink.pusat.indikator.form.edit',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-warning"><i class="fa fa-pen"></i></button>

                      <button onclick="showForm('{{route('sink.pusat.indikator.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')" class="btn  btn-xs btn-info"><i class="fa fa-eye"></i></button>
                      <button class="btn btn-xs bg-navy" onclick="showForm('{{route('sink.pusat.indikator.child_line',['tahun'=>$GLOBALS['tahun_access'],'id'=>$i->id])}}')">
                        <i class="ion ion-merge"></i>
                      </button>
                    </div>
                  </td>
                
                  <td>{{$i->nama_sub_urusan}}</td>
                  <td>{{$i->sumber_data}}</td>
                  <td>
                    <ol>
                          @php 
                            $dukungan_pusat=[];
                            $dukungan_pusat=array_merge($dukungan_pusat,explode('||',$i->dukungan_pusat_lainya));
                            $dukungan_pusat=array_merge($dukungan_pusat,explode('||',$i->dukungan_rkp));
                            
                            $dukungan_pusat=array_unique($dukungan_pusat);


                          @endphp

                          @foreach($dukungan_pusat as $dp)
                            @if(!empty($dp))
                            <li>{!!$dp!!}</li>
                            @endif
                          @endforeach
                          </ol>

                  </td>

                  <td>{{$i->kode}}</td>
                  <td>{{$i->jenis}}</td>


                  <td>{{$i->tolokukur}}</td>
                  <td>{{$i->positiv_value?'POSITIV':'NEGATIF'}}</td>

                  <td>
                    {{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
                  </td>
                  <td>
                    {{$i->satuan}}
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
<script type="text/javascript">
  
  $('#datatable-init').dataTable();
  

</script>
@stop