@extends('layouts.app')

@section('content')


    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-6 login-form-1">
                <h3>Admin - Login</h3>

                <form action="{{route('admin')}}" method="POST">
                    @if(isset($error))
                        <div class="alert alert-danger" role="alert">
                            <strong>{{$error}}</strong>
                        </div>
                    @endif

                    @if(isset($info))
                        <div class="alert alert-primary" role="alert">
                            <strong>{{$info}}</strong>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Tu Email *" value=""/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Tu Password *"
                               value=""/>
                    </div>
                    <center>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Ingresar</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
@endsection
