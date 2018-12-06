<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <style>

        .hand:hover {
            cursor: pointer;
        }

        .login-form-1 {
            padding: 5%;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }

        .login-form-1 h3 {
            text-align: center;
            color: #333;
        }
    </style>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{ asset('js/leaflet/leaflet.css') }}" rel="stylesheet">
    <!--<link rel="stylesheet" href="{asset('css/style.css')}}">
    <link rel="stylesheet" href="{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{asset('images/favicon.png')}}"/>-->
</head>
<body>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <script src="{{ asset('js/leaflet/leaflet.js') }}"></script>
  <script>
    var dashboard = (function () {
      function getAvancePorGestor(fecha) {
        var request = $.ajax({
          url: "{{route('admin.dashboard.getAvancePorGestor')}}",
          method: "POST",
          data: {
              'fecha': fecha
          },
          beforeSend: function() {

          }
        });
        request.done(function (response) {
          var tabla = $("#dash_tabla_gestores tbody");
          var json = response.gestores;
          var content = '', colorBar = 'danger', porcentaje = 0;
          for (var i = 0; i < json.length; i++) {
            porcentaje = Math.round((100 * json[i].realizados) / (json[i].pendientes + json[i].realizados));
            if(porcentaje < 20){
              colorBar = 'danger';
            } else if(porcentaje >= 20 && porcentaje < 50){
              colorBar = 'warning';
            } else if(porcentaje >= 50 && porcentaje < 70){
              colorBar = 'info';
            } else if(porcentaje >= 70 && porcentaje < 100){
              colorBar = 'primary';
            } else if(porcentaje == 100){
              colorBar = 'success';
            }
            content += '<tr>' +
                        '<td>' + json[i].nombre + '</td>' +
                        '<td>' + json[i].realizados + '</td>' +
                        '<td>' + json[i].pendientes + '</td>' +
                        '<td>' +
                          '<div class="progress">' +
                            '<div class="progress-bar bg-' + colorBar + '" role="progressbar" style="width: ' + porcentaje + '%" aria-valuenow="' + porcentaje + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                          '</div>' +
                          porcentaje + '%' +
                        '</td>';
          }
          if(json.length > 0){
            tabla.html(content);
          } else{
            tabla.html('');
          }
        });
      }

      function getAvanceDiario(fecha) {
        var request = $.ajax({
          url: "{{route('admin.dashboard.getAvanceDiario')}}",
          method: "POST",
          data: {
              'fecha': fecha
          },
          beforeSend: function() {

          }
        });
        request.done(function (response) {
          var tabla = $("#dash_tabla_gestores tbody");
          var pendientes = response.pendientes;
          var resueltos = response.resueltos;
          $('#contP').html(pendientes + "<span class='mdi mdi-thumb-down' style='color:#35abde;'></span>");
          $('#contR').html(resueltos + "<span class='mdi mdi-thumb-up' style='color:#95de6b;'></span>");
        });
      }

      function getPointMapGestores(fecha) {
        var request = $.ajax({
          url: "{{route('admin.dashboard.getPointMapGestores')}}",
          method: "POST",
          data: {
              'fecha': fecha
          },
          beforeSend: function() {

          }
        });
        request.done(function (response) {
          var json = response.gestores;
          var size = json.length;
          for (var i = 0; i < size; i++) {
            if(json[i].lat != null){
              L.marker([json[i].lat, json[i].lon]).addTo(mapDashboard)
                .bindPopup("<b>" + json[i].nombre + "</b>").openPopup();
              L.circle([json[i].lat, json[i].lon], 20, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5
              }).addTo(mapDashboard);
            }
          }
        });
      }
      return {
        getAvancePorGestor: function(fecha){
            getAvancePorGestor(fecha);
        },
        getAvanceDiario: function(fecha){
            getAvanceDiario(fecha);
        },
        getPointMapGestores: function(fecha){
            getPointMapGestores(fecha);
        }
      };
    })();

    var visitasMap = (function () {
      function getPointMapVisita(fecha, gestor_id) {
        $('#mensaje').hide();
        mapVisitas.eachLayer(function (layer) {
            mapVisitas.removeLayer(layer);
        });
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
          maxZoom: 18,
          attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
          id: 'mapbox.streets'
        }).addTo(mapVisitas);
        var request = $.ajax({
          url: "{{route('admin.avisos.getPointMapVisita')}}",
          method: "POST",
          data: {
              'fecha': fecha,
              'gestor_id': gestor_id
          },
          beforeSend: function() {

          }
        });
        request.done(function (response) {
          var json = response.puntos;
          var size = json.length;
          var latlngs = [];
          for (var i = 0; i < size; i++) {
            L.marker([json[i].latitud, json[i].longitud]).addTo(mapVisitas)
              .bindPopup("NIC:<b>" + json[i].nic + "</b><br>DIRECCION:<b>" + json[i].direccion + "</b><br>CLIENTE:<b>" + json[i].cliente + "</b><br>ORDEN:<b>" + json[i].orden_realizado + "</b>").openPopup();
            if(i == 0){
              L.circle([json[i].latitud, json[i].longitud], 10, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5
              }).addTo(mapVisitas);
            } else if(i == (size - 1)){
              L.circle([json[i].latitud, json[i].longitud], 10, {
                color: 'green',
                fillColor: '#2BEC0C',
                fillOpacity: 0.5
              }).addTo(mapVisitas);
            }
            latlngs.push([json[i].latitud, json[i].longitud]);
          }
          if(size > 0){
            var polyline = L.polyline(latlngs, {color: 'red'}).addTo(mapVisitas);
            // zoom the map to the polyline
            mapVisitas.fitBounds(polyline.getBounds());
          } else{
            $('#mensaje').show();
          }
        });
      }
      return {
        getPointMapVisita: function(fecha, gestor_id){
            getPointMapVisita(fecha, gestor_id);
        }
      };
    })();
  </script>

  @yield('content')

  <script>
    $(document).ready(function () {
        $fecha = new Date();
        $year = $fecha.getFullYear();
        $month = $fecha.getMonth() + 1;
        $day = $fecha.getDate();
        $fechaNew = null;

        if ($day.toString().length == 1){
            $fechaNew = $year + '-' + $month + '-' + "0" + $day;

        } else {
            $fechaNew = $year + '-' + $month + '-' + $day;
        }

        $('#fecha').val($fechaNew);
        $('#fechaD1').val($fechaNew);
        $('#fechaD2').val($fechaNew);
        $('#fechaAgenda').val($fechaNew);
        $('#fechapagoedit').val($fechaNew);
    });
  </script>

  <script>
    $('#btnIndicador').on('click', function () {
      let fecha = $('#fecha').val();
      dashboard.getAvancePorGestor(fecha);
      dashboard.getAvanceDiario(fecha);
      dashboard.getPointMapGestores(fecha);
    });
  </script>

</body>
</html>
