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

        form {
            padding: 10%;
        }
    </style>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


<script>
    $('#download').on('click', function () {
        location.href = 'http://52.14.94.46/operativa/public/admin/download-avisos';
    });

    $('#carga').on('click', function () {
        location.href = 'http://52.14.94.46/operativa/public/admin/carga-avisos';
    });

    $('#myTable').DataTable({
        ajax: 'http://52.14.94.46/operativa/public/admin/getAvisos',
        responsive: true,
        scrollX: true,
        columns: [
            {'data': 'localidad'},
            {'data': 'barrio'},
            {'data': 'direccion'},
            {'data': 'nic'},
            {'data': 'gestor'}
        ]
    });
</script>
<script>
    $('#reload').on('click', function () {
        if (location.href === 'http://52.14.94.46/operativa/public/admin/dashboard/1') {
            location.reload();
        }

        let loc = location.href;
        let down = 'http://52.14.94.46/operativa/public/admin/download-avisos';
        let carga_avisos = 'http://52.14.94.46/operativa/public/admin/carga-avisos';
        let xxxx = 'http://52.14.94.46/operativa/public/admin/vaciar-carga-avisos';
        let img = 'http://52.14.94.46/operativa/public/admin/img-panel';

        if (loc.includes(down)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://52.14.94.46/operativa/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }

        if (loc.includes(carga_avisos)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://52.14.94.46/operativa/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }

    });
</script>

<script>
    $(document).ready(function () {
        $fecha = new Date();
        $year = $fecha.getFullYear();
        $month = $fecha.getMonth()+1;
        $day = $fecha.getDate();
        console.log($fecha);
        $('#fecha').val($year +'-' + $month +'-' +$day);
    });
</script>
<!--Indicadores busqueda-->
<script>
    $('#btnIndicador').on('click', function () {
        let $fecha = $('#fecha').val();

        let $data = {
            'fecha': $fecha
        };

        $.ajax({
            url: "http://52.14.94.46/operativa/public/admin/getIndicadores",
            type: "POST",
            data: $data,
            success: function (result) {
                if (result.pendientes == 0) {
                    $('#contP').text(result.pendientes);
                    let $msg = "No hay avisos pendientes en la fecha indicada.";
                    alert($msg);
                    $('#contP').empty();
                    $('#contP').append(result.pendientes + "<span class='mdi mdi-thumb-down' style='color:#35abde;'></span>");
                } else {
                    $('#contP').empty();
                    $('#contP').append(result.pendientes + "<span class='mdi mdi-thumb-down' style='color:#35abde;'></span>");
                }
                if (result.realizados == 0) {
                    let $msg = "No hay avisos realizados en la fecha indicada.";
                    alert($msg);
                    $('#contR').empty();
                    $('#contR').append(result.realizados + "<span class='mdi mdi-thumb-up' style='color:#95de6b;'></span>");
                } else {
                    $('#contR').empty();
                    $('#contR').append(result.realizados + "<span class='mdi mdi-thumb-up' style='color:#95de6b;'></span>");
                }
            },
            error: function (error) {
                alert("error")
            }
        });
    });
</script>

</html>
