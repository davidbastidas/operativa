@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"/>
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo">
                    <img src="{{asset('images/electricaribe.jpg')}}" style="width: 170px; height: 50px;">
                </a>
                <a class="navbar-brand brand-logo-mini">
                    <img src="{{asset('images/electricaribe.jpg')}}" style="width: 170px; height: 50px;">
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
                            <form action="{{route('logout')}}" method="POST">
                                {{csrf_field()}}
                                <button type="submit" class="dropdown-item">
                                    Salir
                                </button>
                            </form>
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
                @include('__partials.menu')
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!--Pendientes-->
                    <div class="row">
                        <div class="col-lg-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <center><h4>Carga de Avisos</h4></center>
                                </div>

                                @if(isset($success))
                                    <div class="alert alert-success" role="alert">
                                        <strong>{{$success}}</strong>
                                    </div>
                                @endif

                                <form action="{{route('admin.asignar.avisos')}}" method="post" style="padding: 3%;">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                            <label>Gestor</label>
                                            <select name="gestor" class="form-control">
                                                @foreach($gestores as $gestor)
                                                    <option value="{{$gestor->gestor}}">{{$gestor->gestor   }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Usuarios</label>
                                            <select name="user" class="form-control">
                                                @foreach($usuarios as $user)
                                                    <option value="{{$user->id}}">{{$user->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                           <br>
                                            <button class="btn btn-secondary" style="margin-top: 10px;" type="submit">Asignar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-striped table-bordered" id="myTable">
                                            <thead>
                                            <tr>
                                                <th scope="col">localidad</th>
                                                <th scope="col">barrio</th>
                                                <th scope="col">direccion</th>
                                                <th scope="col">nic</th>
                                                <th scope="col">gestor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                                <form action="{{route('admin.vaciar.carga')}}" method="post" style="padding: 3%;">
                                    <center>
                                        <button class="btn btn-danger" type="submit">Vaciar Carga</button>
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
