@extends('adminlte::master')
@php
$CONF_THEM='dashboardlte';
$CONF_MENU=MENUS::dashboard();
@endphp

@section('adminlte_css')
    
      <script type="text/javascript" src="{{asset('bower_components/js-xlsx/dist/xlsx.core.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('bower_components/file-saverjs/FileSaver.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bower_components/jquery-export/libs/jsPDF/jspdf.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bower_components/jquery-export/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js')}}"></script>
      <script type="text/javascript" src="{{asset('bower_components/jquery-export/tableExport.min.js')}}"></script>
 

    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config($CONF_THEM.'.skin', 'blue') . '.min.css')}} ">
    <style type="text/css">
        .navbar-brand{
            background: #151e63;
        }
    </style>
    @stack('css')
    @yield('css')
    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.theme.default.css?v'.date('i'))}}">

   
   
    

@stop

@section('body_class', 'skin-' . config($CONF_THEM.'.skin', 'blue') . ' sidebar-mini ' . (config($CONF_THEM.'.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config($CONF_THEM.'.layout')] : '') . (config($CONF_THEM.'.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config($CONF_THEM.'.layout') == 'top-nav')
            <nav class="navbar navbar-static-top" data-spy="affix" data-offset-top="100" style="min-width: 100vw;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="{{ url(config($CONF_THEM.'.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config($CONF_THEM.'.logo', '<b>Admin</b>LTE') !!} {{((isset($GLOBALS['tahun_access']))?$GLOBALS['tahun_access']:date('Y'))}}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $CONF_MENU['top'], 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config($CONF_THEM.'.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config($CONF_THEM.'.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config($CONF_THEM.'.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top "  role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    
                       
                      @include('vendor.adminlte.partials.auth_info')

                        
                    </ul>
                </div>
                @if(config($CONF_THEM.'.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config($CONF_THEM.'.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $CONF_MENU['side_left'], 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="bg-navy">
                <p class="text-center"><b>SINKRONISASI PEMDA LINGKUP SUPD II</b></p>
            </div>
            @if(config($CONF_THEM.'.layout') == 'top-nav')
            <div class="container-fluid">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config($CONF_THEM.'.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        @hasSection('footer')
        <footer class="main-footer">
            @yield('footer')
        </footer>
        @endif

        @if(config($CONF_THEM.'.right_sidebar') and (config($CONF_THEM.'.layout') != 'top-nav'))
            <aside class="control-sidebar control-sidebar-{{config($CONF_THEM.'.right_sidebar_theme')}}">
                @yield('right-sidebar')
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        @endif

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('bower_components/jquery-treetable/jquery.treetable.js')}}"></script>
    @stack('js')
    @yield('js')

    <script type="text/javascript">
        $.AdminLTESidebarTweak = {};

        $.AdminLTESidebarTweak.options = {
            EnableRemember: true,
            NoTransitionAfterReload: false
            //Removes the transition after page reload.
        };

        $(function () {
            "use strict";

            $("body").on("expanded.pushMenu collapsed.pushMenu", function(){
                if($.AdminLTESidebarTweak.options.EnableRemember){
                    var toggleState = 'opened';
                    if($("body").hasClass('sidebar-collapse')){
                        toggleState = 'closed';
                    }
                    document.cookie = "toggleState="+toggleState;
                } 
            });


            if($.AdminLTESidebarTweak.options.EnableRemember){
                var re = new RegExp('toggleState' + "=([^;]+)");
                var value = re.exec(document.cookie);
                var toggleState = (value != null) ? unescape(value[1]) : null;
                if(toggleState == 'closed'){
                    if($.AdminLTESidebarTweak.options.NoTransitionAfterReload){
                        $("body").addClass('sidebar-collapse hold-transition').delay(100).queue(function(){
                            $(this).removeClass('hold-transition'); 
                        });
                    }else{
                        $("body").addClass('sidebar-collapse');
                    }
                }
            } 
        })


       function EXPORT_PDF(div,filename='EXPORT-'){
         $(div).tableExport({fileName: filename,
                        type: 'pdf',
                        jspdf: {
                            docDefinition:{pageOrientation:'landscape'},
                            format: 'bestfit',
                            autotable: {styles: {overflow: 'linebreak'}},
                            margins: {left:5, right:5, top:5, bottom:5},

                        }
                                
                       });
       }

       function EXPORT_EXCEL(div,filename='EXPORT'){

             $(div).tableExport({
                        fileName: filename,
                        type:'excel',
                        mso: {fileFormat:'xlsx'}
             
                    });
       }

       if($('.datatable-auto').html()!==undefined){
            $('.datatable-auto').dataTable({
                lengthChange:false
            });
       }

    </script>
@stop
