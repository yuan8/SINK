<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config($CONF_THEM.'.title_prefix', ''))
    @yield('title', config($CONF_THEM.'.title', 'AdminLTE 2'))
    @yield('title_postfix', config($CONF_THEM.'.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @include('adminlte::plugins', ['type' => 'css'])
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/sinkron.css?v='.date('i'))}}">

    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="icon" href="{{asset('asset/icon.gif')}}" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('body_class')">

@yield('body')

<div id="modal_sm" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          
        </div>

      </div>
</div>

<div id="modal_lg" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          
        </div>

      </div>
</div>

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

@include('adminlte::plugins', ['type' => 'js'])

@yield('adminlte_js')
<style type="text/css">
    table tr td{
        font-size:10px;
    }
    table tr th{
        font-size:12px;
    }
</style>
</body>

<script type="text/javascript">
    if(localStorage.local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh){
      
    }else{
      localStorage.setItem("{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh", "OO");
    }

     function buildNum(){
     $('.val_check_type').each(function(key,dom){
        var t=$(dom).text().trim()!=''?$(dom).text().trim():'';

        if(((t!=null)&&(t!=''))){

            if(isNaN(t)==false){
                t=parseFloat(t);
                $(dom).html(new Intl.NumberFormat('de-DE', { }).format(t));
                $(dom).removeClass('val_check_type');

            }
        }
       

     });


   }
    
    buildNum();

    $('html').on('load',buildNum());
    var localy_trigger_refresh=localStorage.getItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh');

    $(window).on("storage", function(e) {
    var event = e.originalEvent; // Get access to the storage-specifics
    if (event.key == "local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh") { // Or whatever
        // Do something with event.newValue
        if(localy_trigger_refresh!=localStorage.getItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh')){
            window.location.reload();
        };
    }
    });
    @if(null!==session('change_urusan'))
        @if(session('change_urusan')!=0)
            localStorage.setItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh',{{session('change_urusan')}});
        @endif
        @php
            session(['change_urusan'=>0]);
        @endphp

    @endif

    function showForm(url,size='lg'){
        $.get(url,function(res){
          $('#modal_'+size+' .modal-content').html(res);
          setTimeout(function(){
              $('#modal_'+size).modal();

          },800);
        });
      }




</script>
</html>
