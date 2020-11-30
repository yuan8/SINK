 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">EDIT MASTER INDIKATOR</h4>
      </div>
<form action="{{route('sink.pusat.indikator.update',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data['id']])}}" method="post">
<div class="modal-body">
	@csrf
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>SUMBER DATA*</label>
			<select class="form-control" name="id_sumber_data" id="add_new_sumber_indikator" required="">
				@if($data['sumber_data'])
				<option value="{{$data['id_sumber']}}" selected>{{$data['sumber_data']}}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-md-6">


		<div class="form-group">
			<label>SUB URUSAN*</label>
			<select class="form-control  select-initial-2" name="id_sub_urusan" required="">
				@foreach($sub_urusan as $su)
					<option value="{{$su->id}}" {{$su->id==$data['id_sub_urusan']?'selected':''}}>{{$su->nama}}</option>
				@endforeach
			</select>
		</div>
	</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>JENIS NILAI*</label>
				<select class="form-control select-initial-2" name="jenis_nilai" id="add_new_indikator_jenis_nilai" required="">
					<option value="SINGLE" {{$data['target_2']==null?'selected':''}}>SINGLE</option>
					<option value="RENTANG" {{$data['target_2']!=null?'selected':''}}>RENTANG NILAI</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>URAIAN*</label>
				<textarea class="form-control" name="uraian" required="">{!!$data['tolokukur']!!}</textarea>

			</div>
		</div>
	<div class="col-md-6">


		<div class="form-group">
			<label id="add_new_indikator_target_label">TARGET*</label>
			<input type="number"  min="0" name="target" class="form-control" required="" value="{{$data['target']}}">
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group" id="add_new_indikator_target_2_form_group" style="display: none;">
			<label id="add_new_indikator_target_2_label">TARGET MAX*</label>
			<input type="number"  min="0" name="target_2" class="form-control" value="{{$data['target_2']}}">
		</div>
	</div>
	<div class="col-md-6">

		<div class="form-group">
			<label >SATUAN*</label>
			<select class="form-control" required="" name="satuan" id="add_new_indikator_satuan">
				<option value="{{$data['satuan']}}" selected="">{{$data['satuan']}}</option>
			</select>
		</div>
	</div>


	<div class="col-md-6">
		<div class="form-group">
			<label>JENIS*</label>
			<select class="form-control  select-initial-2" name="jenis" required="">
				<option value="OUTPUT" {{$data['jenis']=='OUTPUT'?'selected':''}}>OUTPUT</option>
				<option value="OUTCOME" {{$data['jenis']=='OUTCOME'?'selected':''}}>OUTCOME</option>
				<option value="IMPACT" {{$data['jenis']=='IMPACT'?'selected':''}}>IMPACT</option>


			</select>
		</div>
		
		
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>ARAH NILAI*</label>
			<select class="form-control  select-initial-2" name="positiv_value" required="">
				<option value="true" {{$data['positiv_value']?'selected':''}}>POSITIF</option>
				<option value="false"{{(!$data['positiv_value'])?'selected':''}} >NEGATIF</option>


			</select>
		</div>
		
		
	</div>

	<script type="text/javascript">
		$('#add_new_indikator_jenis_nilai').on('change',function(){
			if($(this).val()=='RENTANG'){
				$('#add_new_indikator_target_2_form_group').css('display','block');
				$('#add_new_indikator_target_2_form_group').attr('required',true);

				$('#add_new_indikator_target_label').html('TARGET MIN*');
			}else{
				$('#add_new_indikator_target_2_form_group').css('display','none');
				$('#add_new_indikator_target_2_form_group').attr('required',false);

				$('#add_new_indikator_target_label').html('TARGET*');

			}
		});

		$(function(){
			$('#add_new_indikator_jenis_nilai').trigger('change');
		});

		$('#add_new_sumber_indikator').select2({
			  ajax: {
			    url: '{{route('master.auth.sumber-data-indikator',['tahun'=>$GLOBALS['tahun_access']])}}',
			    data: function (params) {
			      var query = {
			        q: params.term,
			      }

			      // Query parameters will be ?search=[term]&type=public
			      return query;
			    }
			  }
			});

		$('#add_new_indikator_satuan').select2({
			tags:true,
			  ajax: {
			    url: '{{route('master.auth.satuan-data-indikator',['tahun'=>$GLOBALS['tahun_access']])}}',
			    data: function (params) {
			      var query = {
			        q: params.term,
			      }

			      // Query parameters will be ?search=[term]&type=public
			      return query;
			    }
			  }
			});

		$('.select-initial-2').select2();

	</script>
</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary">UPDATE INDIKATOR</button>
	
</div>
</form>