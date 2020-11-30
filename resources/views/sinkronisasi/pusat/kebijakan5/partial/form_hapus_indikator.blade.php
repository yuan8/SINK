<form action="{{route('sink.pusat.kebijakan5.delete.indikator',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data['id']])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>HAPUS INDIKATOR</h4>
	</div>
  <div class="modal-body">
    <p><b>{{$data['nama_indikator']}}</b></p>
  </div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger ">
			HAPUS INDIKATOR
		</button>
	</div>
</form>