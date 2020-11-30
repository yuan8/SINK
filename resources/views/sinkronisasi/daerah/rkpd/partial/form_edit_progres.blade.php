<form action="{{route('sink.daerah.rkpd.progres.update',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_context'=>$GLOBALS['menu_access'],'id'=>$data['kodedata'] ])}}" method="post">
	@csrf
	<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">EDIT PROGRES PELAKSANAAN PROGRAM</h4>
      <i>{{$data['uraiprogram']}}</i>
</div>
<div class="modal-body">
      <div class="form-group">
      	<label>PROGRES (%)*</label>
      	<input type="number" min="0" max="100" required="" name="progress" class="form-control" placeholder="0" value="{{$data['progress']}}">
      </div>
        <div class="form-group">
      	<label>CAPAIAN*</label>
      	<textarea class="form-control" required="" name="capaian" placeholder="uraian capaian..">{!!$data['capaian']!!}</textarea>
      </div>
</div>
<div class="modal-footer">
	<button class="btn btn-primary ">UPDATE</button>
</div>
</form>