@extends('layouts.app')

@section('content')
    @include('__partials.head')
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
                    @include('__partials.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

@endsection
