@extends('layouts.app')

@section('content')
    @include('__partials.head')
    <style>
        #map-visitas { height: 500px; }
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
                      <div class="col-lg-12 grid-margin">
                          <div class="card">
                              <div class="card-body">
                                  <h4 class="card-title">Mapa de visitas</h4>
                                  <div class="row">
                                    <div class="col-md-3">
                                      <select class="form-control" id="gestor_id">
                                        <option value="">[Gestor]</option>
                                        @foreach ($usuarios as $usuario)
                                          <option value="{{$usuario->id}}">{{$usuario->nombre}}</option>
                                        @endforeach
                                      </select>
                                    </div>

                                    <div class="col-md-3">
                                      <input id="fecha" class="form-control" type="date"/>
                                    </div>

                                    <div class="col-md-3">
                                      <button class="btn btn-secondary" id="btnBuscarVisitas">
                                          Buscar visitas
                                      </button>
                                    </div>
                                  </div>
                                  <br>
                                  <p id="mensaje" class="card-description" style="display: none;">No se encontro puntos para las visitas.</p>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div id="map-visitas"></div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <script>
                  var mapVisitas = L.map('map-visitas').setView([10.97, -74.80], 11);

                  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    maxZoom: 18,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                      '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox.streets'
                  }).addTo(mapVisitas);

                  $('#btnBuscarVisitas').on('click', function () {
                    let fecha = $('#fecha').val();
                    let gestor_id = $('#gestor_id').val();
                    visitasMap.getPointMapVisita(fecha, gestor_id);
                  });
                </script>
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
