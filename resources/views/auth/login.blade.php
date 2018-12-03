@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #003a63;
        }

        .yellow {
            background-color: #fec00f;
        }

        .btn-green {
            background-color: #008080;
            color: white;
        }

        .btn-green:hover {
            background-color: #2ab7b5;
            color: white;
        }

        form {
            padding: 0;
        }
    </style>
    <div class="container">
        <br><br><br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <center>
                        <div class="card-header yellow">{{ __('Bienvenido!') }}</div>
                    </center>
                    <div class="card-body body-login">
                        <center><img src="{{asset('/images/electricaribe.png')}}" width="180px;"></center>
                        <br>
                        <form method="POST" action="{{ route('login') }}">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <label>Contraseña</label>
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-green btn-block">
                                        {{ __('Ingresar') }}
                                    </button>
                                </div>
                            </div>

                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
