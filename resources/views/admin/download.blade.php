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
                        <div class="col-lg-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <center><h4>Descargar Avisos</h4></center>
                                </div>

                                @if(isset($info))
                                    <div class="alert alert-primary" role="alert">
                                        <strong>{{$info}}</strong>
                                    </div>
                                @endif

                                <form action="{{route('admin.excel.download')}}" method="post" style="padding: 3%;">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            <label>Desde</label>
                                            <input type="date" id="fechaD1" name="fecha1" required class="form-control"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Hasta</label>
                                            <input type="date" id="fechaD2" name="fecha2" required class="form-control"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Delegacion</label>
                                            <select type="date" name="delegacion" class="form-control">
                                                @foreach($delegaciones as $delegacion)
                                                    <option value="{{$delegacion->id}}">{{$delegacion->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center>
                                        <button class="btn btn-secondary" type="submit">Generar</button>
                                    </center>
                                </form>
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
