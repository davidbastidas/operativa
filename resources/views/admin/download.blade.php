@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"/>


    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo">
                    <img src="{{asset('images/admin.png')}}" alt="logo"/>
                </a>
                <a class="navbar-brand brand-logo-mini">
                    <img src="{{asset('images/admin.png')}}" alt="logo"/>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown d-none d-xl-inline-block">
                        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                           aria-expanded="false">
                            <span class="profile-text">Bienvenido, {{$name}}</span>
                            <img class="img-xs rounded-circle" src="{{asset('images/faces/face1.png')}}"
                                 alt="Profile image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <a class="dropdown-item p-0">
                                <div class="d-flex border-bottom">
                                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                        <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                                    </div>
                                    <div
                                        class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                                        <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                                    </div>
                                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                                        <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                Cambiar Contraseña
                            </a>

                            <a class="dropdown-item" href="{{url('/admin/logout')}}">
                                Salir
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <div class="nav-link">
                            <div class="user-wrapper">
                                <div class="profile-image">
                                    <img src="{{asset('images/faces/face1.png')}}" alt="profile image">
                                </div>
                                <div class="text-wrapper">
                                    <p class="profile-name">{{$name}}</p>
                                    <div>
                                        <small class="designation text-muted">Admin</small>
                                        <span class="status-indicator online"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item hand" id="reload">
                        <a class="nav-link">
                            <i class="menu-icon mdi mdi-television"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item hand" id="download">
                        <a class="nav-link">
                            <i class="menu-icon mdi mdi-file-import"></i>
                            <span class="menu-title">Descargar Avisos</span>
                        </a>
                    </li>
                    <li class="nav-item hand" id="carga">
                        <a class="nav-link">
                            <i class="menu-icon mdi mdi-upload"></i>
                            <span class="menu-title">Carga Avisos</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!--Pendientes-->
                    <div class="row">
                        <div class="col-lg-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <center><h4>Descargar Avisos</h4></center>
                                </div>

                                @if(isset($info))
                                    <div class="alert alert-primary" role="alert">
                                        <strong>{{$info}}</strong>
                                    </div>
                                @endif

                                <form action="{{route('admin.excel.download')}}" method="post" style="padding: 3%;">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            <label>Desde</label>
                                            <input type="date" name="fecha1" required class="form-control"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Hasta</label>
                                            <input type="date" name="fecha2" required class="form-control"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Delegacion</label>
                                            <select type="date" name="delegacion" class="form-control">
                                                @foreach($delegaciones as $delegacion)
                                                    <option value="{{$delegacion->id}}">{{$delegacion->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center>
                                        <button class="btn btn-secondary" type="submit">Generar</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--END Resuletos-->
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="#" target="_blank">David And Julio S.A.S.</a> All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
            </span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

@endsection
