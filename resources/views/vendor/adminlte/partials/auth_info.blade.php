<ul class="nav navbar-nav">
                       <li class="">
                            <a href="{{route('sink.form.tahun_acces',['tahun'=>(isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'),'link_back'=>url()->current()])}}">
                                <i class=" fa fa-calendar "></i>
                                TAHUN ACCESS DATA

                                    </a>
                                </li>

@if(Auth::check())
@if(config($CONF_THEM.'.right_sidebar') and (in_array(Auth::User()->role,[1,3])))
    <li>
      <a href="#" data-toggle="control-sidebar" ><i class="fa fa-link"></i> URUSAN</a>
    </li>
@endif
 <li class="dropdown user user-menu ">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
      <img src="{{asset('asset/user.png')}}" class="user-image" alt="User Image">
      <span class="hidden-xs">.</span>
    </a>
    <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header bg-{{config($CONF_THEM.'.skin', 'blue')}}">
        <img src="{{asset('asset/user.png')}}" class="img-circle" alt="User Image">

        <p>
          {{Auth::User()->name}}
          <small>{{Auth::User()->email}}</small>
        </p>
      </li>
      <li>
        <p style="font-size: 12px" class=" text-center text-uppercase"><b>environment</b></p>
      </li>
      <!-- Menu Body -->
      <li class="user-body">
        <ul class="control-sidebar-menu">
          <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('index',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}">
              <i class="menu-icon ion ion-speedometer bg-primary"></i>
              <div class="menu-info" style="padding-top: 5px;">
                <h4 class="control-sidebar-subheading">DASHBOARD</h4>

              </div>
            </a>
          </li>
          @can('accessPusat')
            <li style="border-bottom: 1px solid #ddd">
              <a href="{{route('sink.pusat.index',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}">
                <i class="menu-icon ion ion-merge bg-info"></i>
                <div class="menu-info" style="padding-top: 5px;">
                  <h4 class="control-sidebar-subheading">PEMETAAN PUSAT</h4>

                </div>
              </a>
            </li>

          @endcan
          <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('sink.daerah.init',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}">
              <i class="menu-icon ion bg-green ion-pull-request"></i>
              <div class="menu-info" style="padding-top: 5px;">
                <h4 class="control-sidebar-subheading">PEMETAAN DAERAH</h4>

              </div>
            </a>
          </li>
          @if(Auth::User()->role==1)
            <li style="border-bottom: 1px solid #ddd">
            <a href="{{route('sink.admin.index',['tahun'=>isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:2020])}}">
              <i class="menu-icon ion  ion-settings bg-red"></i>
              <div class="menu-info" style="padding-top: 5px;">
                <h4 class="control-sidebar-subheading">SUPERADMIN</h4>

              </div>
            </a>
          </li>
          @endif
        </ul>
        
        <!-- /.row -->
      </li>
      <!-- Menu Footer-->
      <li class="user-footer">
         <form id="logout-form" action="{{ url(config($CONF_THEM.'.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
            @if(config($CONF_THEM.'.logout_method'))
                {{ method_field(config($CONF_THEM.'.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
        <div class="pull-left">
          <a href="#" class="btn btn-default btn-flat">Profile</a>
        </div>
        <div class="pull-right">
          <a href="javascript:void(0)"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
        </div>
      </li>
    </ul>
  </li>
  
@else
<li>
  <a href="{{url('login')}}">
      <i class="fa fa-user-circle"></i> Login
  </a> 
</li>

@endif