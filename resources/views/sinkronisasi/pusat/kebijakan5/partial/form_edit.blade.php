<form action="{{route('sink.pusat.kebijakan5.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data['id']])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>UPDATE {{$item['context']}}</h4>
	</div>
	<div class="modal-body">
		 <div class="row">
       @if($item['context']=='ARAH KEBIJAKAN')
        <div class="col-md-12">
            <div class="form-group">
              <label>SUB URUSAN </label>
              <select class="form-control" name="sub_urusan" required="">
                @foreach($sub_urusan as $su)
                  <option value="{{$su->id}}" {{$data['id_sub_urusan']==$su->id?'selected':''}}>{{$su->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
        @endif
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