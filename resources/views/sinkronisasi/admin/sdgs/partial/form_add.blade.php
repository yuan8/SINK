<form action="{{route('sink.admin.sdgs.store',['tahun'=>$GLOBALS['tahun_access'],'id'=>$parent['parent']])}}" method="post">
	@csrf
	<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4>TAMBAH {{$parent['child_context']}}</h4>
	</div>
	<div class="modal-body">
		 <div class="row">
          @if($parent['parent'])
            <input type="hidden" name="parent" value="{{$parent['parent']}}">
          @endif
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" name="jenis" value="{{$parent['child_context']}}">
              <label>URAIAN {{$parent['child_context']}}</label>
              <textarea class="form-control" name="uraian"></textarea>
            </div>
          </div>
          @if($parent['child_context']=='SASARAN NASIONAL')
          
          <div class="col-md-6">
            <div class="form-group">
                <label>PELAKSANA {{$parent['child_context']}}</label>
                <textarea class="form-control" name="pelaksana"></textarea> 
            </div>
          </div>
          
          @endif
        </div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary ">
			TAMABAH {{$parent['child_context']}}
		</button>
	</div>
</form>