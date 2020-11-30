<form action="{{route('sink.pusat.kebijakan5.store',['tahun'=>$GLOBALS['tahun_access'],'id'=>$item['parent']])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>TAMBAH {{$item['child_context']}}</h4>
	</div>
	<div class="modal-body">
		 <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" name="jenis" value="{{$item['child_context']}}">
              <label>URAIAN {{$item['child_context']}}</label>
              <textarea class="form-control" name="uraian" required=""></textarea>
            </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
              <label>KETERANGAN </label>
              <textarea class="form-control" name="keterangan"></textarea>
            </div>
          </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary ">
			TAMBAH {{$item['child_context']}}
		</button>
	</div>
</form>