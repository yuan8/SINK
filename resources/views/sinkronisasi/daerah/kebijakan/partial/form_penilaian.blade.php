<form action="{{route('sink.daerah.kebijakan.penilaian.update',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$data['id']])}}" method="post">
  @csrf
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>PENILAIAN KEBIJAKAN </h4>
  </div>
  <div class="modal-body">

     <div class="row">
       
         <div class="col-md-12">
            <div class="form-group">
              <label>PENILAIAN*</label>
              <select class="form-control" name="penilaian" required="">
                <option value="1" {{$data['penilaian']==1?'selected':''}}>SESUAI</option>
                <option value="2" {{$data['penilaian']==2?'selected':''}}>BELUM SESUAI</option>
                <option value="0" {{$data['penilaian']==0?'selected':''}}>BELUM DINILAI</option>
              </select>
            </div>
          </div>
           
          <div class="col-md-12">
            <div class="form-group">
              <label>CATATAN PENILAIAN</label>
              <textarea class="form-control" name="uraian_note" required="">{!!$data['uraian_note']!!}</textarea>
            </div>
          </div>
           
        </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary ">
      UPDATE PENILAIAN
    </button>
  </div>
</form>