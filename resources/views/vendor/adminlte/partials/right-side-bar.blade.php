<div class="col-md-12">
    <ul class="control-sidebar-menu">
        @foreach(session('list_urusan') as $key=> $u)
     
          <li>
            <a href="{{route('sink.form.ubah_urusan',['tahun'=>$GLOBALS['tahun_access'],'back_link'=>url()->current(),'id_urusan'=>$u->id])}}">
              <i class="menu-icon fa fa-check {{$u->id==session('main_urusan')->id?'bg-red':'bg-gray'}}"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">{{$u->nama}}</h4>

              </div>
            </a>
          </li>
          @endforeach   
         
</div>