@php
	$iddom='table-'.rand(0,1000);
@endphp
 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">DETAIL INDIKATOR</h4>
      </div>
<div class="modal-body">
	<table class="table table-bordered" id="{{$iddom}}">
		<thead>
			<tr>
			<th>SUB URUSAN</th>
			<th>SUMBER DATA</th>
			<th>KODE</th>
			<th>JENIS</th>
			<th>TOLOKUKUR</th>
			<th>ARAH NILAI</th>
			<th>TARGET PUSAT</th>
			<th>SATUAN</th>
		</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$data->nama_sub_urusan}}</td>
				<td>{{$data->sumber_data}}</td>
				<td>{{$data->kode}}</td>
				<td>{{$data->jenis}}</td>
				<td>{{$data->tolokukur}}</td>
				<td>{{$data->positiv_value?'POSITIF':'NEGATIF'}}</td>
				<td>
					{{!empty($data->target_2)?number_format($data->target).' - '.number_format($data->target_2):number_format($data->target)}}
				</td>
				<td>{{$data->satuan}}</td>
			</tr>
			<tr data-tt-id="IND_{{$data->id}}" class="bg-success">
				<td colspan="8"><span class="text-center">TURUNAN INDIKATOR ({{count($data->child)}})</span></td>
			</tr>
			@foreach($data->child as $i)
			<tr data-tt-id="IND_{{$i->id}}" data-tt-parent-id="IND_{{$data->id}}">
				<td>{{$i->nama_sub_urusan}}</td>
				<td>{{$i->sumber_data}}</td>
				<td>{{$i->kode}}</td>
				<td>{{$i->jenis}}</td>
				<td>{{$i->tolokukur}}</td>
				<td>{{$i->positiv_value?'POSITIF':'NEGATIF'}}</td>
				<td>
					{{!empty($i->target_2)?number_format($i->target).' - '.number_format($i->target_2):number_format($i->target)}}
				</td>
				<td>{{$i->satuan}}</td>
			</tr>
			@endforeach
			
			
		</tbody>
	</table>
	<h5><b>KEWENANGAN</b></h5>

	<h5><b>RPJMN</b></h5>
	<h5><b>RKP</b></h5>


	<h5><b>CARA HITUNG</b></h5>
	<p>
		{{$data->cara_hitung}}
	</p>

</div>

<script type="text/javascript">
	
	$('#{{$iddom}}').treetable({ expandable: true,column:0 });
</script>

