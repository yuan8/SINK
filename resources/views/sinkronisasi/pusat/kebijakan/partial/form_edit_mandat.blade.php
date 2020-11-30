<form action="{{route('sink.pusat.kebijakan.mandat.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$mandat->id])}}" method="post">
	@csrf
	<div class="modal-header">
		<h5>EDIT MANDAT</h5>
	</div>
	<div class="modal-body">
		 <div class="row">
          <div class="col-md-6">
            <div class="form-group">
             
                <label>JENIS</label>
              <select class="form-control" name="jenis">
                <option value="REGULASI" {{ $mandat->jenis=='REGULASI'?'selcted':''}}>REGULASI</option>
                <option value="KEGIATAN" {{ $mandat->jenis=='KEGIATAN'?'selcted':''}}>KEGIATAN</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>SUB URUSAN</label>
              <select class="form-control" name="id_sub_urusan">
                @foreach($sub_urusan as $su)
                  <option value="{{$su->id}}" {{$su->id == $mandat->id_sub_urusan?'selected':''}}>{{$su->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>URAIAN</label>
              <textarea class="form-control" name="uraian">{!!$mandat->uraian!!}</textarea>
            </div>
          </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary ">
			UPDATE
		</button>
	</div>
</form>