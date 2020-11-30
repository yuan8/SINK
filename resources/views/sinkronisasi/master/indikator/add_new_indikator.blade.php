<form action="{{$url_tagging}}" method="post">
	@csrf
	<input type="hidden" name="{{$name_parent}}" value="{{$parent}}">
	<div class="row">
	<input type="hidden" name="add_new_indikator_form" value="true" id="add_new_indikator_form">
	<div class="col-md-6">
		<div class="form-group">
			<label>SUMBER DATA*</label>
			<select class="form-control" name="id_sumber_data" id="add_new_sumber_indikator" required="">
				
			</select>
		</div>
	</div>
	<div class="col-md-6">


		<div class="form-group">
			<label>SUB URUSAN*</label>
			<select class="form-control  select-initial-2" name="id_sub_urusan" required="">
				@foreach($sub_urusan as $su)
					<option value="{{$su->id}}">{{$su->nama}}</option>
				@endforeach
			</select>
		</div>
	</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>JENIS NILAI*</label>
				<select class="form-control select-initial-2" name="jenis" id="add_new_indikator_jenis_nilai" required="">
					<option value="SINGLE">SINGLE</option>
					<option value="RENTANG">RENTANG NILAI</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>URAIAN*</label>
				<textarea class="form-control" name="uraian" required=""></textarea>

			</div>
		</div>
	<div class="col-md-6">


		<div class="form-group">
			<label id="add_new_indikator_target_label">TARGET*</label>
			<input type="number"  min="0" name="target" class="form-control" required="">
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group" id="add_new_indikator_target_2_form_group" style="display: none;">
			<label id="add_new_indikator_target_2_label">TARGET MAX*</label>
			<input type="number"  min="0" name="target_2" class="form-control">
		</div>
	</div>
	<div class="col-md-6">

		<div class="form-group">
			<label >SATUAN*</label>
			<select class="form-control" required="" name="satuan" id="add_new_indikator_satuan">
				
			</select>
		</div>
	</div>


	<div class="col-md-6">
		<div class="form-group">
			<label>JENIS*</label>
			<select class="form-control  select-initial-2" name="jenis" required="">
				<option value="OUTPUT">OUTPUT</option>
				<option value="OUTCOME">OUTCOME</option>
				<option value="IMPACT">IMPACT</option>


			</select>
		</div>
		
		
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>ARAH NILAI*</label>
			<select class="form-control  select-initial-2" name="positiv_value" required="">
				<option value="true">POSITIF</option>
				<option value="false">NEGATIF</option>


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
<hr>
<button type="submit" class="btn btn-primary">TAMBAH</button>

</form>