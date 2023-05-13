<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Lang::get('layout.brand-text') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('css/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('css/OverlayScrollbars.min.css')}}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
    <!-- pie-chart -->
    <link rel="stylesheet" href="{{asset('css/chart.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('style')
    @routes
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href={{url("/home")}} class="nav-link">{{ Lang::get('layout.home') }}</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href={{ route('checklists.index') }} class="nav-link">{{ Lang::get('layout.nav-header-checklists') }}</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                    <i class="fa fa-sign-out" style="font-size:24px;color:red"></i>--}}
{{--                </a>--}}
{{--                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                    @csrf--}}
{{--                </form>--}}
{{--            </li>--}}
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <div style="text-align: center" class="brand-link">
            <span class="brand-text font-weight-light">{{ Lang::get('layout.brand-text') }}</span>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('img/user_icon.png')}}" class="img-circle elevation-2" alt="User Image"
                         style="opacity: .8">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{Auth::user()->name}}</a>
                </div>
            </div>

            @isset($showChart)
            <div style="text-align:center;" class="user-panel mt-3 pb-3 mb-3" >
                <div>
                    <span class="chart" data-percent="">
                        <span class="percent"></span>
                    </span>
                </div>
                <div style="color: #efefef" class="info">
                    <strong id="completedTasks"></strong> out of <strong id="totalTasks"></strong> decroting task
                    <br>
                    completed on checklist
                </div>
            </div>
            @endisset

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul id="checklistsUL" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
{{--                    <li class="nav-header">{{ Lang::get('layout.nav-header-checklists') }}</li>--}}
{{--                    @foreach($checklists as $checklist)--}}
{{--                    <li class="nav-item">--}}
{{--                        <a onclick={{"showChart($checklist->id)"}} href={{url("index/".$checklist->id)}} class="nav-link">--}}
{{--                            <i class="fas fa-circle nav-icon"></i>--}}
{{--                            <p>{{$checklist->name}}</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @endforeach--}}
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
                <br>
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('js/jquery.vmap.usa.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('js/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('js/demo.js')}}"></script>
<!-- toastr -->
<script src="{{asset('js/toastr.js')}}"></script>
<!-- pie chart -->
<script src="{{asset('js/chart.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>

<script>
    getChecklists();
    function getChecklists(){
        $.ajax({
            type: "get",
            url: '/getChecklists',
            success: function (response) {
                $("#checklistsUL").html("");
                var element1 = '<li class="nav-header">checklists</li>';
                $("#checklistsUL").append(element1);
                $.each(response.checklists, function(index, value) {
                     var element2 ='<li class="nav-item">\n' +
                        '                        <a onclick="showChart('+value['id']+')" href="/index/'+value['id']+'") class="nav-link">\n' +
                        '                            <i class="fas fa-circle nav-icon"></i>\n' +
                        '                            <p>'+value['name']+'</p>\n' +
                        '                        </a>\n' +
                        '                    </li>';
                    $("#checklistsUL").append(element2);
                })
            }
        });
    }
</script>
@yield('scripts')
</body>
</html>
