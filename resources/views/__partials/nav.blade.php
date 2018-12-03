<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center notme"
         style="background-color: #003a63">
        <a class="navbar-brand brand-logo">
            <img src="{{asset('images/electricaribe.png')}}" style="width: 170px; height: 50px;">
        </a>
        <a class="navbar-brand brand-logo-mini">
            <img src="{{asset('images/electricaribe.png')}}" style="width: 170px; height: 50px;">
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center" style="background-color: #008080">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-xl-inline-block">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                   aria-expanded="false">
                    <span class="profile-text">Bienvenido, {{$name}}</span>
                    <img class="img-xs rounded-circle" src="{{asset('images/faces/face1.png')}}"
                         alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <br>
                    <form action="{{route('logout')}}" method="POST" style="padding: 0">
                        {{csrf_field()}}
                        <button type="submit" class="dropdown-item">
                            Salir
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
