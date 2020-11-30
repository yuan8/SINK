<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">MASUKAN DATA INDIKATOR</h4>
      <p class="text-uppercase"><i>{{strtolower(!isset($title)?'':$title)}}</i></p>
</div>
<div class="modal-body">
  {{!isset($title)?'<small class="text-uppercase">'.$title.'</small>':''}}
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tagging_ind">TAGGING</a></li>
    <li><a data-toggle="tab" href="#add_new_ind">TAMBAH INDIKATOR BARU</a></li>
  </ul>

  <div class="tab-content" style="margin-top: 20px;">
    <div id="tagging_ind" class="tab-pane fade in active">
      @include('sinkronisasi.master.indikator.list_chose')
    </div>
    <div id="add_new_ind" class="tab-pane fade">
      @include('sinkronisasi.master.indikator.add_new_indikator')
    </div>
  </div>
</div>

<?php

