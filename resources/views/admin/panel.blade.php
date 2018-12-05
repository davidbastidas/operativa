@extends('layouts.app')

@section('content')
    @include('__partials.head')
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
                                  <div class="row">
                                      <div class="col-md-3">
                                          <input id="fecha" class="form-control" type="date" name="fecha" required/>
                                      </div>
                                      <div class="col-md-4">
                                          <button class="btn btn-secondary" id="btnIndicador">
                                              Buscar Fecha
                                          </button>
                                      </div>
                                  </div>
                                  <br>
                                  <center><h2 class="card-title text-primary mb-5">Avance por Gestor</h2></center>
                                  <div class="table-responsive">
                                    <table class="table table-bordered" id="dash_tabla_gestores">
                                      <thead>
                                        <tr>
                                          <th>
                                            Gestor
                                          </th>
                                          <th>
                                            Realiz.
                                          </th>
                                          <th>
                                            Pendi.
                                          </th>
                                          <th>
                                            Avance
                                          </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <center><h2 class="card-title text-primary mb-5">Avance Diario</h2></center>
                                      <center>
                                          <p class="mb-2">Total Resueltos</p>
                                          <p id="contR" class="display-3 mb-5 font-weight-light">
                                            <span class="mdi mdi-thumb-up" style="color:#95de6b;"></span>
                                          </p>
                                      </center>
                                      <center><p class="mb-2">Total Pendientes</p>
                                          <p id="contP" class="display-3 mb-4 font-weight-light">
                                            <span class="mdi mdi-thumb-down" style="color:#35abde;"></span>
                                          </p>
                                      </center>
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
                                    <h4 class="card-title">Ultima ubicacion</h4>
                                    <div class="row">
                                      <div class="col-md-12">
                                        mapa
                                      </div>
                                    </div>
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
                 @include('__partials.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
