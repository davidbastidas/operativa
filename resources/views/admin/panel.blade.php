@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"/>
    <style>
        form {
            padding: 0;

        }
        .table-wrapper-scroll-y {
            display: block;
            max-height: 300px;
            overflow-y: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
    </style>

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
            @include('__partials.nav')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
                @include('__partials.menu')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <center><h2 class="card-title text-primary mb-5">Ultimos 50 Realizados</h2></center>
                                    <div class="table-wrapper-scroll-y">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">Nombre Gestor</th>
                                                <th scope="col">Barrio</th>
                                                <th scope="col">Fecha</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($last50 as $last)
                                                <tr>
                                                    <th>{{$last->nombre}}</th>
                                                    <td>{{$last->barrio}}</td>
                                                    <td>{{$last->fecha_recibido_servidor}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <center><h2 class="card-title text-primary mb-5">Produccion Diaria</h2></center>
                                    <center><p class="mb-2">Total Pendientes</p>
                                        <p id="contP" class="display-3 mb-4 font-weight-light"><span
                                                class="mdi mdi-thumb-down" style="color:#35abde;"></span></p>
                                    </center>
                                    <center>
                                        <p class="mb-2">Total Resueltos</p>
                                        <p id="contR" class="display-3 mb-5 font-weight-light"><span
                                                class="mdi mdi-thumb-up" style="color:#95de6b;"></span></p>
                                    </center>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input id="fecha" class="form-control" type="date" name="fecha" required/>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-secondary" id="btnIndicador">
                                                Ver
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Pendientes-->
                    <div class="row">
                        <div class="col-lg-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Location GPS</h4>
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.3387002318436!2d-74.82985228583699!3d11.013194492161118!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8ef42c4d4ad7ec73%3A0x9ab6eda3d5142548!2sCentro+Comercial+Buenavista!5e0!3m2!1ses-419!2sco!4v1543199574416"
                                        width="100%" height="400px" frameborder="0" style="border:0"
                                        allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--End Pendientes-->

                    <!--Resuletos-->
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


