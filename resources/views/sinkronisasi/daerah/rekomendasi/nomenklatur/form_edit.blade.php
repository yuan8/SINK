@php
	$iddom='ind_list-'.rand(0,1000);
@endphp
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">EDIT {{$parent['nm']}}</h4>

</div>
<form action="{{route('sink.daerah.rekomendasi.update',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$data['id_bridge']])}}" method="post">
	@csrf
	<div class="modal-body" style="max-height: 400px; overflow-y: scroll;">
	<table class="table-bordered table">
		<thead>
			<tr>
				<th>KODE</th>
				<th>JENIS</th>

				<th>NOMENKLATUR</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$data['kode']}}</td>
				<td>{{$data['jenis']}}</td>
				<td>{{$data['uraian']}}</td>
			</tr>
		</tbody>
	</table>
	@if($data['jenis']!='PROGRAM')
		<p><b>LIST PERMASALAHAN</b></p>
     	<table class="table table-bordered" id="{{$iddom}}">
		<thead>
				<tr>
					<th>PILIH</th>
					<th>JENIS</th>

					<th>URAIAN</th>
					<th>KATEGORI</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data_ms as $ms)
					<tr>
						<td>
							<input type="radio" {{$data['id_ms']==$ms->id?'checked':''}} name="ms" value="{{$ms->id}}">
						</td>
						<td>{{$ms->jenis}}</td>
						<td>{!!nl2br($ms->uraian)!!}</td>
						<td>{!!nl2br($ms->kategori)!!}</td>

					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
	@if($data['jenis']=='KEGIATAN')
	<label>PAGU</label>
	<input type="number" min="0" name="pagu" class="form-control" value="{{$data['pagu']??0}}">
	@endif
	<label>KETERANGAN</label>
	<textarea class="form-control" name="keterangan">{!!$data['keterangan']!!}</textarea>
</div>
<div class="modal-footer">
	<button type="submit" class="btn btn-primary">UPDATE</button>
</div>

</form>