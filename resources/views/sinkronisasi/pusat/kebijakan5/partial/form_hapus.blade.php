<form action="{{route('sink.pusat.kebijakan5.delete',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data['id']])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>HAPUS {{$item['context']}}</h4>
	</div>
  <div class="modal-body">
    <p><b>{{$data['jenis'].' : '.$data['uraian']}}</b></p>
  </div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger ">
			HAPUS {{$item['context']}}
		</button>
	</div>
</form>