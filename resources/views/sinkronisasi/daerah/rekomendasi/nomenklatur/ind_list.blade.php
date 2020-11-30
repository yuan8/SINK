@php
	$iddom='ind_list-'.rand(0,1000);
@endphp

<form action="{{route('sink.daerah.rekomendasi.ind.store',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$parent['id_bridge']])}}" method="post">
	@csrf
	<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">TAMBAH  INDIKATOR {{$parent['jenis']}}</h4>

</div>
<div class="modal-body" style="max-height: 400px; overflow-y: scroll;">

     <table class="table table-bordered" id="{{$iddom}}">
		<thead>
							<tr>
								<th>PILIH</th>

								<th>SUB URUSAN</th>
								<th>KODE</th>
								<th>JENIS</th>

								<th>TOLOKUKUR</th>
								<th>JENIS NILAI</th>

								<th>TARGET PUSAT</th>

								<th>SATUAN</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $i)
								<tr>
									<td style="min-width: 40px">
										<input type="radio" class="{{$iddom}}add_new_indikator_jenis_nilai"  name="indikator[]" data-tipe="{{$i->target_2?'multy':'single'}}"  value="{{$i->id}}">
									</td>
									
									<td>{{$i->nama_sub_urusan}}</td>
									<td>{{$i->kode}}</td>
									<td>{{$i->jenis}}</td>


									<td>{{$i->tolokukur}}</td>
									<td>{{$i->positiv_value?'POSITIV':'NEGATIF'}}</td>

									<td>
										{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
									</td>
									<td>
										{{$i->satuan}}
									</td>
								</tr>
							@endforeach
		</tbody>
	</table>
	<div class="row">
		<div class="col-md-6">


		<div class="form-group">
			<label id="{{$iddom}}add_new_indikator_target_label">TARGET*</label>
			<input type="number"  min="0" name="target" class="form-control" required="">
		</div>
		</div>

		<div class="col-md-6">
			<div class="form-group" id="{{$iddom}}add_new_indikator_target_2_form_group" style="display: none;">
				<label id="{{$iddom}}add_new_indikator_target_2_label">TARGET MAX*</label>
				<input type="number"  min="0" name="target_2" class="form-control">
			</div>
		</div>
	</div>

	<div class="form-group">
		<label>KETERANGAN</label>
		<textarea class="form-control" name="keterangan"></textarea>
	</div>
</div>
<div class="modal-body">
	
</div>
<div class="box-footer">
	<button type="submit" class="btn btn-primary">TAMBAH</button>
</div>

</form>

<script type="text/javascript">
		$('.{{$iddom}}add_new_indikator_jenis_nilai').on('change',function(){
			if(($(this).attr('data-tipe')=='multy')&&($(this).prop('checked'))){
				$('#{{$iddom}}add_new_indikator_target_2_form_group').css('display','block');
				$('#{{$iddom}}add_new_indikator_target_2_form_group').attr('required',true);

				$('#{{$iddom}}add_new_indikator_target_label').html('TARGET MIN*');
			}else{
				$('#{{$iddom}}add_new_indikator_target_2_form_group').css('display','none');
				$('#{{$iddom}}add_new_indikator_target_2_form_group').attr('required',false);

				$('#{{$iddom}}add_new_indikator_target_label').html('TARGET*');

			}
		});

		$(function(){
			$('.{{$iddom}}add_new_indikator_jenis_nilai').trigger('change');
		});
</script>