<form action="{{route('sink.pusat.kebijakan5.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data['id']])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>UPDATE {{$item['context']}}</h4>
	</div>
	<div class="modal-body">
		 <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>URAIAN {{$item['context']}}</label>
              <textarea class="form-control" name="uraian" required="">{!!$data['uraian']!!}</textarea>
            </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
              <label>KETERANGAN </label>
              <textarea class="form-control" name="keterangan">{!!$data['keterangan']!!}</textarea>
            </div>
          </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary ">
			UPDATE {{$item['context']}}
		</button>
	</div>
</form>