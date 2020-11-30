<form action="{{route('sink.pusat.indikator.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data['id']])}}" method="post">
	 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">HAPUS MASTER INDIKATOR</h4>
      </div>
<div class="modal-body">
	@csrf
	<P><b>{{$data['tolokukur']}}</b></P>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-danger">HAPUS INDIKATOR</button>
	
</div>
</form>