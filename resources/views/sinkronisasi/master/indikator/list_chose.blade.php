<form action="{{$url_tagging}}" method="post">
	<input type="hidden" name="tagging_indikator" value="true" >
	<input type="hidden" name="{{$name_parent}}" value="{{$parent}}">

	@csrf
	<table class="table table-bordered">
	<thead>
		<tr>
			<th>PILIH</th>
			<th>SUB URUSAN</th>
			<th>KODE</th>
			<th>SUMBER DATA</th>
			<th>JENIS</th>
			<th>ARAH NILAI</th>
			<th>TOLOKUKUR</th>
			<th>TARGET</th>
			<th>SATUAN</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $ind)
			<tr>
				<td><input type="checkbox" name="indikator[]" value="{{$ind->id}}"></td>
				<td>{{$ind->nama_sub_urusan}}</td>
				<td>{{$ind->kode}}</td>
				<td>{{$ind->sumber_data}}</td>
				<td>{{$ind->jenis}}</td>
				<td>{{$ind->positiv_value?'POSITIF':'NEGATIF'}}</td>
				<td>{{$ind->tolokukur}}</td>
				<td>{{!empty($ind->target_2)?number_format($ind->target).' - '.number_format($ind->target_2):number_format($ind->target)}}</td>
				<td>{{$ind->satuan}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="btn-group">
	<button class="btn btn-primary">TAMBAH</button>
</div>

</form>
