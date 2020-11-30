<form action="{{route('sink.pusat.kebijakan.mandat.del',['tahun'=>$GLOBALS['tahun_access'],'id'=>$mandat->id])}}" method="post">
	@csrf
	<div class="modal-header">
		<h5>HAPUS MANDAT</h5>
	</div>
	<div class="modal-body">
		 <div class="row">
          <div class="col-md-6">
            {!! $mandat->uraian !!}
        </div>
	</div>
	<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
		<button type="submit" class="btn btn-danger ">
			DELETE
		</button>
	</div>
</form>