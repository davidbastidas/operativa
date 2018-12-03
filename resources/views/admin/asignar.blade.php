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
                              @endif
                              <hr>
                              <div class="row">
                                <div class="col-md-10">
                                    <h4>Lista de Avisos {{$agendaModel->codigo}} de {{$agendaModel->fecha}}</h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="table-responsive">
                                    <table class="table text-center">
                                      <thead>
                                        <tr>
                                            <th scope="col">Agenda</th>
                                            <th scope="col">Delegacion</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Por Asignar</th>
                                            <th scope="col">Pend.</th>
                                            <th scope="col">Reali.</th>
                                            <th scope="col">Accion</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
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
