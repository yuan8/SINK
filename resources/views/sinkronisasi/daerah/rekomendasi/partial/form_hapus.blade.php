<form action="{{route('sink.daerah.rekomendasi.delete',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$data['id_bridge']])}}" method="post">
  @csrf
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>HAPUS REKOMENDASI {{$item['nm']}}</h4>
  </div>
  <div class="modal-body">

     <div class="row">
       
         <div class="col-md-12">
            <p><b>{{$item['nm'].'/'.$item['kode'].' - '.$data['uraian']}}</b></p>
           
        </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-danger ">
      HAPUS {{$item['nm']}}
    </button>
  </div>
</form>