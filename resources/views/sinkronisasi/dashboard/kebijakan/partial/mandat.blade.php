<p><b>{{$d->name}} ({{$d->provinsi_implemented?'IMPLEMENTASI':'BELUM IMPLEMENTASI'}})</b></p>
<br>
<p>PEMDA IMPLEMENTASI:{{number_format($d->jumlah_pemda_implemented)}} PEMDA</p><br>
<p>PEMDA SESUAI IMPLEMENTASI:{{number_format($d->jumlah_mandat_pemda_sesuai)}} PEMDA</p><br>
<p>PEMDA TIDAK SESUAI IMPLEMENTASI:{{number_format($d->jumlah_mandat_pemda_tidak_sesuai)}} PEMDA</p><br>
<p>PERSENTASE IMPLEMENTASI PEMDA:{{number_format($d->value,1)}} %</p>


