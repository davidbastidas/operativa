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
                                    <center><h4>Asignar Avisos</h4></center>
                                </div>

                                @if(isset($success))
                                    <div class="alert alert-success" role="alert">
                                        <strong>{{$success}}</strong>
                                    </div>
                                @endif

                                <form action="{{route('admin.asignar.avisos')}}" method="post" style="padding: 3%;">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                            <label>Gestor</label>
                                            <select name="gestor" class="form-control">
                                                @foreach($gestores as $gestor)
                                                    <option value="{{$gestor->gestor}}">{{$gestor->gestor   }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Usuarios</label>
                                            <select name="user" class="form-control">
                                                @foreach($usuarios as $user)
                                                    <option value="{{$user->id}}">{{$user->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                           <br>
                                            <button class="btn btn-secondary" style="margin-top: 10px;" type="submit">Asignar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-striped table-bordered" id="myTable">
                                            <thead>
                                            <tr>
                                                <th scope="col">localidad</th>
                                                <th scope="col">barrio</th>
                                                <th scope="col">direccion</th>
                                                <th scope="col">nic</th>
                                                <th scope="col">gestor</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                                <form action="{{route('admin.vaciar.carga')}}" method="post" style="padding: 3%;">
                                    <center>
                                        <button class="btn btn-danger" type="submit">Vaciar Carga</button>
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
