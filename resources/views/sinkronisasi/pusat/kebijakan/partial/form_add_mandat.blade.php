<div id="form_add_mandat" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{route('sink.pusat.kebijakan.mandat.store',['tahun'=>$GLOBALS['tahun_access']])}}" method="post">
        @csrf
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TAMBAH MANDAT</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
            
                <label>JENIS</label>
              <select class="form-control" name="jenis">
                <option value="REGULASI" >REGULASI</option>
                <option value="KEGIATAN">KEGIATAN</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>SUB URUSAN</label>
              <select class="form-control" name="id_sub_urusan">
                @foreach($sub_urusan as $su)
                  <option value="{{$su->id}}">{{$su->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>URAIAN</label>
              <textarea class="form-control" name="uraian"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
         <button type="submit" class="btn btn-primary">TAMBAH</button>
      </div>
      </form>
    </div>

  </div>
</div>