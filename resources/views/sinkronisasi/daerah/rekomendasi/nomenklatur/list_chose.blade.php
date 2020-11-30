@php
	$iddom='sjkskjkswos0-'.rand(0,1000);
@endphp

<form action="{{route('sink.daerah.rekomendasi.nomen_list_chose',['tahun'=>$GLOBALS['tahun_access'],'kodepemda'=>$GLOBALS['pemda_access']->id,'menu_access'=>$GLOBALS['menu_access'],'id'=>$parent['parent']])}}{{isset($parent['id_ms'])?'?id_ms='.$parent['id_ms']:''}}" method="post">
	@csrf
	<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">TAMBAH  NOMENKLATUR {{$parent['child_context']}}</h4>

</div>
<div class="modal-body" style="max-height: 400px; overflow-y: scroll;">
	<input type="hidden" name="parent" value="{{$parent['parent']}}">
	@if(isset($parent['id_ms']))
	<input type="hidden" name="id_ms" value="{{$parent['id_ms']}}">
	@endif
     <table class="table table-bordered" id="{{$iddom}}">
		<thead>
		<tr>

			<th style="width:50px;">PILIH</th>
			<th  style="width:100px;">KODE</th>
			<th  style="width:80px;">JENIS</th>

			<th>URAIAN</th>
			<th style="width:80px; ">PERUNTUHAN</th>

			
		</tr>
		</thead>
		<tbody>
			@foreach($data as $d)
			<tr>
			
				<td>
					<input type="checkbox" name="nomenklatur[{{$d->kode}}]" value="{{$d->id}}">
				</td>
				<td>
					{{$d->kode}}
				</td>
				<td>{{$d->jenis}}</td>
				<td>{!!nl2br($d->uraian)!!}</td>
				<td>{!!($d->provinsi?'PROVINSI':'KAB/KOTA')!!}</td>

			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="modal-body">

	<label>KETERANGAN</label>
	<textarea class="form-control" name="keterangan"></textarea>
</div>
<div class="box-footer">
	<button type="submit" class="btn btn-primary">TAMBAH</button>
</div>

</form>