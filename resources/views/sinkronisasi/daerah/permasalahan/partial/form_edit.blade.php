<form action="{{route('sink.daerah.permasalahan.update',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$data['id']])}}" method="post">
  @csrf
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>TAMBAH {{$item['context']}}</h4>
  </div>
  <div class="modal-body">
    <input type="hidden" name="jenis" value="{{$item['context']}}">

     <div class="row">
    
        @if($item['context']=='MASALAH')
         <div class="col-md-12">
            <div class="form-group">
              <label>KATEGORI PERMASALAHAN*</label>
              <select class="form-control" name="kategori" required="">
                <option value="LAINYA" {{$data['uraian_sumber_data']=='LAINYA'?'selected':''}}>LAINYA</option>
                <option value="REGULASI" {{$data['uraian_sumber_data']=='REGULASI'?'selected':''}}>REGULASI</option>
                <option value="PELAYANAN" {{$data['uraian_sumber_data']=='PELAYANAN'?'selected':''}}>PELAYANAN</option>
                <option value="KEUANGAN" {{$data['uraian_sumber_data']=='KEUANGAN'?'selected':''}}>KEUANGAN</option>
                <option value="SDM" {{$data['uraian_sumber_data']=='SDM'?'selected':''}}>SDM</option>
                <option value="OPRASIOANAL" {{$data['uraian_sumber_data']=='OPRASIOANAL'?'selected':''}}>OPRASIOANAL</option>
              </select>
            </div>
          </div>
        @endif
          <div class="col-md-12">
            <div class="form-group">
              <label>URAIAN {{$item['context']}}*</label>
              <textarea class="form-control" name="uraian" required="">{!!$data['uraian']!!}</textarea>
            </div>
          </div>
           @if($item['context']=='MASALAH')
           <div class="col-md-12">
              <div class="form-group">
                <label>SUMBER DATA</label>
                <select class="form-control" name="uraian_sumber_data">
                  <option value="RPJMD" {{$data['uraian_sumber_data']=='RPJMD'?'selected':''}}>RPJMD</option>
                  <option value="RKPD ({{$GLOBALS['tahun_access']}})" {{$data['uraian_sumber_data']==('RKPD ('.$GLOBALS['tahun_access'].')')?'selected':''}}>RKPD ({{$GLOBALS['tahun_access']}})</option>
                  <option value="LAINYA" {{$data['uraian_sumber_data']=='LAINYA'?'selected':''}}>LAINYA</option>
                  </select>
              </div>
            </div>
           <div class="col-md-12">
              <div class="form-group">
                <label>TINDAK LANJUT</label>
                <textarea class="form-control" name="tindak_lanjut">{!!$data['tindak_lanjut']!!}</textarea>
              </div>
            </div>
          @endif
        </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary ">
      UPDATE {{$item['context']}}
    </button>
  </div>
</form>