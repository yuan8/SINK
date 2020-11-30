<p><b>{{$d->name}} - MANDAT SESUAI</b></p>
<br>
@if($d->jumlah_mandat_regulasi_sesuai and $mandat->jumlah_mandat_regulasi)
<p>MANDAT REGULASI :{{(number_format(($d->jumlah_mandat_regulasi_sesuai/$mandat->jumlah_mandat_regulasi)*100,1))}}% ({{$d->jumlah_mandat_regulasi_sesuai}} Sesuai ({{$d->jumlah_mandat_regulasi}})/{{$mandat->jumlah_mandat_regulasi}})</p>
@else
<p>MANDAT REGULASI :0% ({{$d->jumlah_mandat_regulasi_sesuai}} Sesuai ({{$d->jumlah_mandat_regulasi}})/{{$mandat->jumlah_mandat_regulasi}})</p>
@endif
<br>

@if($d->jumlah_mandat_kegiatan_sesuai and $mandat->jumlah_mandat_kegiatan)
<p>MANDAT KEGIATAN :{{(number_format(($d->jumlah_mandat_kegiatan_sesuai/$mandat->jumlah_mandat_kegiatan)*100,1))}}% ({{$d->jumlah_mandat_kegiatan_sesuai}} Sesuai ({{$d->jumlah_mandat_kegiatan}})/{{$mandat->jumlah_mandat_kegiatan}})</p>
@else
<p>MANDAT KEGIATAN :0% ({{$d->jumlah_mandat_kegiatan_sesuai}} Sesuai ({{$d->jumlah_mandat_kegiatan}})/{{$mandat->jumlah_mandat_kegiatan}})</p>

@endif
<br>

@if($d->jumlah_mandat_implemented and $mandat->jumlah_mandat)
<p>PERSENTASE  TOTAL :{{number_format((($d->jumlah_mandat_sesuai/$mandat->jumlah_mandat)*100),1).'%'.' ('.$d->jumlah_mandat_sesuai.'/'.$mandat->jumlah_mandat.')'}} </p>
@else
<p>PERSENTASE  TOTAL  :{{'0%'.' ('.$d->jumlah_mandat_sesuai.'/'.$mandat->jumlah_mandat.')'}} </p>


@endif
