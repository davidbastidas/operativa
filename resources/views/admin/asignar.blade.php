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
                              @if(count($gestores) > 0)
                                <div class="row">
                                  <div class="col-md-10">
                                      <h4>Asignar Avisos {{$agendaModel->codigo}} de {{$agendaModel->fecha}}</h4>
                                  </div>
                                  <div class="col-md-2">
                                    <form action="{{route('admin.vaciar.carga')}}" method="post">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="agenda" value="{{$agenda}}">
                                      <button class="btn btn-danger" type="submit">Vaciar Carga</button>
                                    </form>
                                  </div>
                                </div>

                                @if(isset($success))
                                    <div class="alert alert-success" role="alert">
                                        <strong>{{$success}}</strong>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                      <form action="{{route('admin.asignar.avisos')}}" method="post">
                                          <input type="hidden" name="agenda" value="{{$agenda}}">
                                          <div class="form-group">
                                            <label>Gestor Cargado</label>
                                            <select name="gestor" class="form-control">
                                                @foreach($gestores as $gestor)
                                                  <option value="{{$gestor->gestor}}">{{$gestor->gestor}}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>Gestor a Asignar</label>
                                            <select name="user" class="form-control">
                                                @foreach($usuarios as $user)
                                                    <option value="{{$user->id}}">{{$user->nombre}}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                          <button class="btn btn-success mr-2" type="submit">
                                              Asignar Uno
                                          </button>
                                      </form>
                                      <br>
                                      <form action="{{route('admin.asignarall')}}" method="post">
                                        <input type="hidden" name="agenda" value="{{$agenda}}">
                                        <button class="btn btn-outline-info" type="submit">Asignar Todo</button>
                                      </form>
                                    </div>
                                </div>
                                <hr>
                              @endif

                              <div class="row">
                                <div class="col-md-10">
                                    <h4>Lista de Avisos {{$agendaModel->codigo}} de {{$agendaModel->fecha}}</h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="table-responsive">
                                    <table style="width: 100%;text-align:center;" class="table-bordered">
                                      <thead>
                                        <tr>
                                            <th style="width: 5%;padding: 10px;">#</th>
                                            <th style="width: 20%;">Gestor</th>
                                            <th style="width: 15%;">Barrio</th>
                                            <th style="width: 10%;">NIC</th>
                                            <th style="width: 10%;">Result.</th>
                                            <th style="width: 10%;">Accion</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($avisos as $aviso)
                                          <tr>
                                            <td>{{ $aviso->id }}</td>
                                            <td>{{ $aviso->usuario->nombre }}</td>
                                            <td>{{ $aviso->barrio }}</td>
                                            <td>{{ $aviso->nic }}</td>
                                            <td>
                                              @if (isset($aviso->resultado->nombre))
                                                {{ $aviso->resultado->nombre }}
                                              @endif
                                            </td>
                                            <td>
                                                <form action="{{route('aviso.editar', ['aviso' => $aviso->id])}}">
                                                    <button style="margin-bottom: 8px" class="btn-block btn btn-outline-primary">
                                                        Ver <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                </form>

                                                <form action="{{route('aviso.eliminar', ['aviso' => $aviso->id])}}">
                                                    <button style="margin-bottom: 8px" class="btn-block btn btn-outline-danger">
                                                        Eliminar <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                    <br>
                                    {{ $avisos->appends([])->links() }}
                                  </div>
                                </div>
                              </div>
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
