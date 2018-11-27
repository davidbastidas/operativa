<style>
    nav ul li a:hover:not(#UserDropdown){
        background-color: #d69d0f !important;
    }
    .menu-eca{
        background-color: #003a63;

    }

    ul li span{
        color: white !important;
    }

    ul li p{
        color: white !important;
    }

    ul li i{
        color: white !important;
    }

</style>

<nav class="sidebar sidebar-offcanvas menu-eca" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image">
                        <img src="{{asset('images/faces/face1.png')}}" alt="profile image">
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name">{{$name}}</p>
                        <div>
                            <small class="designation text-muted">Admin</small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item hand" id="reload">
            <a class="nav-link" href="{{route('admin.dashboard', $id)}}">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item hand">
            <a class="nav-link" href="{{route('admin.excel.index', $id)}}">
                <i class="menu-icon mdi mdi-upload-multiple"></i>
                <span class="menu-title">Subir Avisos</span>
            </a>
        </li>

        <li class="nav-item hand">
            <a class="nav-link" href="{{route('carga.avisos', $id)}}">
                <i class="menu-icon mdi mdi-arrow-collapse-up"></i>
                <span class="menu-title">Asignar Avisos</span>
            </a>
        </li>

        <li class="nav-item hand" id="download">
            <a class="nav-link" href="{{route('download.avisos', $id)}}">
                <i class="menu-icon mdi mdi-file-import"></i>
                <span class="menu-title">Descargar Avisos</span>
            </a>
        </li>
    </ul>
</nav>
