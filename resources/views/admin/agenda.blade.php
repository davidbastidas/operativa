@extends('layouts.app')

@section('content')
    @include('__partials.head')

    <style>
        button:hover {
            cursor: pointer;
        }

        th {
            text-align: center;
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
                                    <center><h3>AGENDAS</h3></center>
                                    <br><br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class="btn btn-success btn-block" data-toggle="modal"
                                                    data-target="#modal">Nueva Agenda
                                            </button>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Nueva Agenda</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form style="padding: 0;" action="{{route('agenda.save')}}"
                                                          method="POST">
                                                        {{csrf_field()}}
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-1"></div>
                                                                <div class="col-md-5">
                                                                    <label>Fecha</label>
                                                                    <input id="fechaAgenda" type="date"
                                                                           class="form-control" name="fecha">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label>Delegacion</label>
                                                                    <select class="form-control" name="delegacion">
                                                                        @foreach($delegaciones as $del)
                                                                            <option
                                                                                value="{{$del->id}}">{{$del->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cerrar
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Guardar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4"></div>
                                        <div class="col-md-4" style="top: -20px;">
                                            <center><p class="mb-2">Total Avisos</p>
                                                <p class="display-3 mb-4 font-weight-light"><span
                                                        class="mdi mdi-bell" style="color:#35abde;">
                                                        {{$totalAvisos}}
                                                    </span></p>
                                            </center>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Agenda</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Delegacion</th>
                                            <th scope="col">Usuario Carga</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($agendas as $agenda)
                                            <tr>
                                                <th scope="row">{{$agenda->codigo}}</th>
                                                <td>{{$agenda->fecha}}</td>
                                                <td>
                                                    @if($agenda->delegacion == 1)
                                                        ATLANTICO NORTE
                                                    @else
                                                        ATLANTICO SUR
                                                    @endif
                                                </td>
                                                <td>{{$agenda->usuario}}</td>
                                                <td>
                                                    <button class="btn-primary btn-block">Abrir <i
                                                            class="mdi mdi-folder-open"></i></button>
                                                    <button class="btn-info btn-block">Cargar <i
                                                            class="mdi mdi-upload"></i>
                                                    </button>
                                                    <button class="btn-danger btn-block">Eliminar <i
                                                            class="mdi mdi-delete"></i></button>
                                                    <button class="btn-success btn-block">Descargar <i
                                                            class="mdi mdi-download"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                    {{ $agendas->appends([])->links() }}

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
