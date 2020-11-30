<form action="{{route('sink.daerah.permasalahan.store',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$item['parent']])}}" method="post">
  @csrf
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>TAMBAH {{$item['child_context']}}</h4>
  </div>
  <div class="modal-body">
    <input type="hidden" name="jenis" value="{{$item['child_context']}}">

     <div class="row">
    
        @if($item['child_context']=='MASALAH')
         <div class="col-md-12">
            <div class="form-group">
              <label>KATEGORI PERMASALAHAN*</label>
              <select class="form-control" name="kategori" required="">
                <option value="LAINYA">LAINYA</option>
                <option value="REGULASI">REGULASI</option>
                <option value="PELAYANAN">PELAYANAN</option>
                <option value="KEUANGAN">KEUANGAN</option>
                <option value="SDM">SDM</option>
                <option value="OPRASIOANAL">OPRASIOANAL</option>
              </select>
            </div>
          </div>
        @endif
          <div class="col-md-12">
            <div class="form-group">
              <label>URAIAN {{$item['child_context']}}*</label>
              <textarea class="form-control" name="uraian" required=""></textarea>
            </div>
          </div>
           @if($item['child_context']=='MASALAH')
           <div class="col-md-12">
              <div class="form-group">
                <label>SUMBER DATA</label>
                <select class="form-control" name="uraian_sumber_data">
                  <option value="RPJMD">RPJMD</option>
                  <option value="RKPD ({{$GLOBALS['tahun_access']}})">RKPD ({{$GLOBALS['tahun_access']}})</option>
                  <option value="LAINYA">LAINYA</option>
                  </select>
              </div>
            </div>
           <div class="col-md-12">
              <div class="form-group">
                <label>TINDAK LANJUT</label>
                <textarea class="form-control" name="tindak_lanjut"></textarea>
              </div>
            </div>
          @endif
        </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary ">
      TAMBAH {{$item['child_context']}}
    </button>
  </div>
</form>