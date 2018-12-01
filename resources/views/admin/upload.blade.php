@extends('layouts.app')

@section('content')
    @include('__partials.head')

    <style>
        span{
            font-size: 20px;
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
                                    <center><h3>SUBIR AVISOS EN EXCEL</h3></center>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-4" style="top: -20px;">
                                            <center><p class="mb-2">Agenda</p>
                                                <p class="display-3 mb-4 font-weight-light"><span
                                                        class="mdi mdi-book-open-page-variant" style="color:#35abde;">
                                                        {{$agenda->codigo}}
                                                    </span></p>
                                            </center>
                                        </div>
                                        <div class="col-md-4" style="top: -20px;">
                                            <center><p class="mb-2">Delegacion</p>
                                                <p class="display-3 mb-4 font-weight-light"><span
                                                        class="mdi mdi-map-marker" style="color:#35abde;">
                                                        @if($agenda->delegacion_id == 1)
                                                            ATLANTICO NORTE
                                                        @else
                                                            ATLANTICO SUR
                                                        @endif
                                                    </span></p>
                                            </center>
                                        </div>
                                        <div class="col-md-4" style="top: -20px;">
                                            <center><p class="mb-2">Fecha</p>
                                                <p class="display-3 mb-4 font-weight-light"><span
                                                        class="mdi mdi-calendar" style="color:#35abde;">
                                                        {{$fecha}}
                                                    </span></p>
                                            </center>
                                        </div>
                                    </div>

                                    <br>
                                    <form method="post" action="{{route('admin.avisos.upload')}}"
                                          enctype="multipart/form-data" style="padding: 0">
                                        <input type="hidden" name="agenda" value="{{$agenda->id}}">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-7">
                                                <input class="form-control" type="file" name="file"/>
                                            </div>
                                            <div class="col-md-3">
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
