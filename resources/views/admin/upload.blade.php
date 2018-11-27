@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.addons.css')}}">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"/>


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
                                    <center><h4 class="card-title">Subir Avisos en Excel</h4></center>
                                    <br><br>
                                    <form method="post" action="{{route('admin.avisos.upload')}}"
                                          enctype="multipart/form-data" style="padding: 0">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-7">
                                                <input class="form-control" type="file" name="file"/>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary" type="submit">Subir</button>
                                            </div>
                                        </div>
                                    </form>
                                    <br><br>
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
