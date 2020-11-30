<div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-maroon">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PEMETAAN PERMASALAHAN {{$GLOBALS['tahun_access']}}</span>
              <span class="info-box-number">{{number_format($data->jumlah_pemda)}} PEMDA</span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    {{number_format($data->qty)}} MASALAH
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
         
</div>