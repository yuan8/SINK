@php
	$iddom='sjkskjkswos0-'.rand(0,1000);
@endphp

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">LIST PERMASALAHAN  {{$GLOBALS['pemda_access']->nama_pemda}}</h4>

</div>
<div class="modal-body">
     <table class="table table-bordered" id="{{$iddom}}">
		<thead>
		<tr>
			<th  style="width:100px;">SUB URUSAN</th>

			<th style="width:100px;">JENIS</th>
			<th>URAIAN</th>
			
		</tr>
		</thead>
		<tbody>
			@if(!empty($data))


			<tr data-tt-id="ms_{{$data->id}}" >
				<td>-</td>
				<td>{{$data->jenis}}</td>
				<td>{!!nl2br($data->uraian)!!}</td>
			</tr>
			@foreach($data->masalah as $m)
			<tr data-tt-id="ms_{{$m->id}}" data-tt-parent-id="ms_{{$m->id_parent}}">
				<td>
					{{$m->nama_sub_urusan}}
				</td>
				<td>{{$m->jenis}}</td>
			
				<td>{!!nl2br($m->uraian)!!}</td>
			</tr>
			@foreach($m->data_dukung as $d)
				<tr data-tt-id="ms_{{$d->id}}" data-tt-parent-id="ms_{{$d->id_parent}}">
					<td>
						{{$d->nama_sub_urusan}}
					</td>
					<td>{{$d->jenis}}</td>
				
					<td>{!!nl2br($d->uraian)!!}</td>
				</tr>
				@endforeach
			@endforeach
			@endif
		</tbody>
	</table>
</div>
</div>
<script type="text/javascript">
	$('#{{$iddom}}').treetable({ expandable: true,column:1,initialState:'expanded' });

</script>