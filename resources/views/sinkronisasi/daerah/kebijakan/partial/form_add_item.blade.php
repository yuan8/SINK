<form action="{{route('sink.daerah.kebijakan.store',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$parent->id])}}" method="post">
  @csrf
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>TAMBAH KEBIJAKAN DAERAH</h4>
  </div>
  <div class="modal-body">

     <div class="row">
       
         <div class="col-md-12">
            <div class="form-group">
              <label>JENIS*</label>
              <select class="form-control" name="jenis" required="">
                <option value="PERDA">PERDA</option>
                <option value="PERKADA">PERKADA</option>
                <option value="LAINYA">LAINYA</option>
              </select>
            </div>
          </div>
           <div class="col-md-6">
            <div class="form-group">
                <label>TAHUN BERLAKU KEBIJAKAN</label>
                <input type="number" name="tahun_berlaku" class="form-control" min="2000">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>URAIAN KEBIJAKAN*</label>
              <textarea class="form-control" name="uraian" required=""></textarea>
            </div>
          </div>
           
        </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary ">
      TAMBAH KEBIJAKAN
    </button>
  </div>
</form>