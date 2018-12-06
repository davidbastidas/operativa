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
        #map-dashboard { height: 350px; }
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
                                <div class="table-responsive" style="height: 300px;overflow-y: scroll;overflow-x: none;font-size: 12px;">
                                  <table id="dash_tabla_gestores" style="width: 90% !important;margin: 10px;text-align: center;">
                                    <thead>
                                      <tr>
                                        <th style="width: 25% !important;">
                                          Gestor
                                        </th>
                                        <th style="width: 20% !important;">
                                          Realiz.
                                        </th>
                                        <th style="width: 20% !important;">
                                          Pendi.
                                        </th>
                                        <th style="width: 25% !important;">
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

                  <div class="row">
                      <div class="col-lg-12 grid-margin">
                          <div class="card">
                              <div class="card-body">
                                  <h4 class="card-title">Ultima ubicacion</h4>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div id="map-dashboard"></div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                 @include('__partials.footer')
                <!-- partial -->
            </div>

            <script>
              var mapDashboard = L.map('map-dashboard').setView([10.97, -74.80], 11);

              L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                  '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                  'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox.streets'
              }).addTo(mapDashboard);

              var fecha = new Date();
              var year = fecha.getFullYear();
              var month = fecha.getMonth() + 1;
              var day = fecha.getDate();
              var fechaNew = null;

              if (day.toString().length == 1){
                  fechaNew = year + '-' + month + '-' + "0" + day;

              } else {
                  fechaNew = year + '-' + month + '-' + day;
              }

              dashboard.getAvancePorGestor(fechaNew);
              dashboard.getAvanceDiario(fechaNew);
              dashboard.getPointMapGestores(fechaNew);
            </script>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
