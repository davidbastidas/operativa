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
        location.href = 'http://localhost:8888/operativa/public/admin/download-avisos';
    });

    $('#carga').on('click', function () {
        location.href = 'http://localhost:8888/operativa/public/admin/carga-avisos';
    });

    $('#myTable').DataTable({
        ajax: 'http://localhost:8888/operativa/public/admin/getAvisos',
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
        if (location.href === 'http://localhost:8888/operativa/public/admin/dashboard/1') {
            location.reload();
        }

        let loc = location.href;
        let down = 'http://localhost:8888/operativa/public/admin/download-avisos';
        let solved = 'http://localhost:8888/operativa/public/admin/solved/';
        let graph = 'http://localhost:8888/operativa/public/admin/graph';
        let img = 'http://localhost:8888/operativa/public/admin/img-panel';

        if (loc.includes(down)) {
            $id = '{{$id}}';
            let replaceUrl = 'http://localhost:8888/operativa/public/admin/dashboard/' + $id;
            location.href = replaceUrl;
        }
    });
</script>

</html>
