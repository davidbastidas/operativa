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
<!--<div class="container-scroller">
   nclude('__partials/nav')
   <div class="container-fluid page-body-wrapper">
       include('__partials/menu')
       <div class="main-panel">
           <div class="content-wrapper">
               yield('content')
           </div>
       </div>
       include('__partials/footer')
   </div>

</div> -->
@yield('content')
</body>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="{{ asset('js/leaflet/leaflet.js') }}"></script>

<script>
      var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point([0, 0]),
        name: 'Null Island',
        population: 4000,
        rainfall: 500
      });

      var iconStyle = new ol.style.Style({
        image: new ol.style.Icon(/** @type {module:ol/style/Icon~Options} */ ({
          anchor: [0.5, 46],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'https://openlayers.org/en/v5.3.0/examples/data/icon.png'
        }))
      });

      iconFeature.setStyle(iconStyle);

      var vectorSource = new ol.source.Vector({
        features: [iconFeature]
      });

      var vectorLayer = new ol.layer.Vector({
        source: vectorSource
      });

      var rasterLayer = new ol.layer.Tile({
        source: new ol.source.TileJSON({
          url: 'https://api.tiles.mapbox.com/v3/mapbox.geography-class.json?secure',
          crossOrigin: ''
        })
      });

      var map = new ol.Map({
        layers: [rasterLayer, vectorLayer],
        target: document.getElementById('map'),
        view: new ol.View({
          center: [0, 0],
          zoom: 3
        })
      });

      var element = document.getElementById('popup');

      var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -50]
      });
      map.addOverlay(popup);

      // display popup on click
      map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
          function(feature) {
            return feature;
          });
        if (feature) {
          var coordinates = feature.getGeometry().getCoordinates();
          popup.setPosition(coordinates);
          $(element).popover({
            placement: 'top',
            html: true,
            content: feature.get('name')
          });
          $(element).popover('show');
        } else {
          $(element).popover('destroy');
        }
      });

      // change mouse cursor when over marker
      map.on('pointermove', function(e) {
        if (e.dragging) {
          $(element).popover('destroy');
          return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTarget().style.cursor = hit ? 'pointer' : '';
      });
/*
    var markerSource = new ol.source.Vector();
    var markerStyle = new ol.style.Style({
      image: new ol.style.Icon(({
        anchor: [0.5, 46],
        anchorXUnits: 'fraction',
        anchorYUnits: 'pixels',
        opacity: 0.75,
        src: 'https://openlayers.org/en/v5.3.0/examples/data/icon.png'
      }))
    });
    var map = new ol.Map({
      target: 'map',
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        }),
        new ol.layer.Vector({
          source: markerSource,
          style: markerStyle,
        }),
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([-74.80 ,10.97]),
        zoom: 12
      })
    });
    function addMarker(lon, lat) {
      var iconFeatures = [];

      var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat])),
        name: 'Null Island',
        population: 4000,
        rainfall: 500
      });
      iconFeature.setStyle(markerStyle)
      markerSource.addFeature(iconFeature);

      var element = document.getElementById('popup');

      var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -50]
      });
      map.addOverlay(popup);
    }
    addMarker(-74.88473166666667, 10.897871666666667);*/
    //Cargar fecha de hoy al input de los contadores
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

        var fecha = $('#fecha').val();
        dashboard.getAvancePorGestor(fecha);
        dashboard.getAvanceDiario(fecha);
        dashboard.getPointMapGestores(fecha);
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
          content = '<tr>' +
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
        for (var i = 0; i < json.length; i++) {
          json[i].nombre
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
</script>

</html>
