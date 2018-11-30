@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"/>

    <style>
        button:hover {
            cursor: pointer;
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
                    <!--Pendientes-->
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <center><h3>AGENDAS</h3></center>
                                    <br><br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class="btn btn-success btn-block" data-toggle="modal"
                                                    data-target="#modal">Nueva Agenda
                                            </button>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Nueva Agenda</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-5">
                                                                <label>Fecha</label>
                                                                <input id="fechaAgenda" type="date" class="form-control" name="fecha">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label>Delegacion</label>
                                                                <select class="form-control" name="delegacion">
                                                                    @foreach($delegaciones as $del)
                                                                        <option
                                                                            value="{{$del->id}}">{{$del->nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cerrar
                                                        </button>
                                                        <button type="button" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4"></div>
                                        <div class="col-md-4" style="top: -20px;">
                                            <center><p class="mb-2">Total Avisos</p>
                                                <p class="display-3 mb-4 font-weight-light"><span
                                                        class="mdi mdi-bell" style="color:#35abde;">
                                                        {{$totalAvisos}}
                                                    </span></p>
                                            </center>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Agenda</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Delegacion</th>
                                            <th scope="col">Usuario Carga</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">00001</th>
                                            <td>2018-11-28</td>
                                            <td>Norte</td>
                                            <td>David Bastidas</td>
                                            <td>
                                                <button class="btn-primary btn-block">Abrir <i
                                                        class="mdi mdi-folder-open"></i></button>
                                                <button class="btn-info btn-block">Cargar <i class="mdi mdi-upload"></i>
                                                </button>
                                                <button class="btn-danger btn-block">Eliminar <i
                                                        class="mdi mdi-delete"></i></button>
                                                <button class="btn-success btn-block">Descargar <i
                                                        class="mdi mdi-download"></i></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
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
              <a href="#" target="_blank">GestionAvisos 1.1</a> All rights reserved.</span>
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
