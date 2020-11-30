<form action="{{route('sink.pusat.kebijakan.mandat.store.kb',['tahun'=>$GLOBALS['tahun_access'],'id'=>$mandat->id,'context'=>$context])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>TAMBAH {{$context}}</h4>
	</div>
	<div class="modal-body">
		 <div class="row">
          
          <div class="col-md-6">
            <div class="form-group">
                <label>TAHUN BERLAKU {{$context}}</label>
                <input type="number" name="tahun_berlaku" class="form-control" min="2000">
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" name="jenis" value="{{$context}}">
              <label>URAIAN {{$context}}</label>
              <textarea class="form-control" name="uraian"></textarea>
            </div>
          </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary ">
			TAMABAH {{$context}}
		</button>
	</div>
</form>