<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="localhost/serviciodeginecologia/public/">

    <title>Hospital Raúl Leoni - {{$title}}</title>

    <!-- Custom fonts for this template-->
    <link href="{{Vite::asset('resources/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{Vite::asset('resources/scss/sb-admin-2.scss')}}" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/')}}">
                <div class="sidebar-brand-icon">
                    <img style="max-height: 5rem;" src="{{Vite::asset('resources/img/logo-hospital-raul-leoni-no-bg.png')}}" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">Hospital Raúl Leoni</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{url('/dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Panel de usuario
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            @if(\Auth::user()->rol !== "PATIENT")
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                        aria-expanded="true" aria-controls="collapseUsers">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>
                            @if(\Auth::user()->rol !== "ADMIN")
                                Administrar pacientes
                            @else
                                Administrar usuarios
                            @endif
                        </span>
                    </a>
                    <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                            @if(\Auth::user()->rol !== "ADMIN")
                                <a class="collapse-item"  href="{{url('/getPatients')}}">Pacientes</a>
                            @else
                                <a class="collapse-item"  href="{{url('/getPatients')}}">Pacientes</a>
                                <a class="collapse-item" href="{{url('/getAdmins')}}">Administradores</a>
                                <a class="collapse-item" href="{{url('/getDoctors')}}">Doctores</a>
                                <a class="collapse-item"  href="{{url('/getSecretaries')}}">Secretarios</a>
                            @endif
                        </div>
                    </div>
                </li>
            @endif

            @if(\Auth::user()->rol == "PATIENT")
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/referenciasPaciente/'.\Auth::id())}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Referencias</span></a>
                    <a class="nav-link" href="{{url('/ExamenesPaciente/'.\Auth::id())}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Examenes</span></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConsultations"
                    aria-expanded="true" aria-controls="collapseConsultations">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Citas</span>
                </a>
                <div id="collapseConsultations" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                        @if(\Auth::user()->rol != "PATIENT")
                            @if(\Auth::user()->rol == "DOCTOR")
                                <a class="collapse-item"  href="{{url('/listaCitasDoctor/'.\Auth::id())}}">Ver proximas citas</a>
                            @else
                                <a class="collapse-item"  href="{{url('/listaCitas')}}">Ver proximas citas</a>
                            @endif
                            <a class="collapse-item" href="{{url('/agendarDisponibilidad')}}">Disponibilidad doctor</a>
                        @endif
                        @if(\Auth::user()->rol == "PATIENT")
                            <a class="collapse-item"  href="{{url('/listaCitasPaciente/'.\Auth::id())}}">Ver proximas citas</a>
                        @endif
                        <a class="collapse-item"  href="{{url('/agendarCita')}}">Agendar citas</a>
                    </div>
                </div>
            </li>
            @if(\Auth::user()->rol != "PATIENT")
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsMorbilidad"
                        aria-expanded="true" aria-controls="collapsMorbilidad">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Morbilidad Diaria</span>
                    </a>
                    <div id="collapsMorbilidad" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                            <a class="collapse-item" href="{{url('/registrarmorbilidad')}}">Registrar morbilidad</a>
                            <a class="collapse-item" href="{{url('/consultarmorbilidad')}}">Consultar morbilidad</a>
                        </div>
                    </div>

                </li>
            @endif
            @if (in_array(\Auth::user()->rol, ["ADMIN", "SECRETARY"]))
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNoticias"
                        aria-expanded="true" aria-controls="collapseNoticias">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Noticias</span>
                    </a>
                    <div id="collapseNoticias" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                            <a class="collapse-item" href="{{url('/registrarnoticias')}}">Registrar noticias</a>
                            <a class="collapse-item" href="{{url('/consultarnoticias')}}">Consultar noticias</a>
                        </div>
                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{url('/registrareventos')}}" data-toggle="collapse" data-target="#collapseEventos"
                        aria-expanded="true" aria-controls="collapseEventos">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Eventos</span>
                    </a>
                    <div id="collapseEventos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                            <a class="collapse-item" href="{{url('/registrareventos')}}">Registrar Eventos</a>

                        </div>
                    </div>

                </li>
            @endif

            <hr class="sidebar-divider my-2 mb-0">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    {{-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> --}}

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @php
                                    $user = \Auth::user();
                                @endphp
                                <span class="mr-2 d-inline text-gray-600 small">{{$user->name}} {{$user->last_name}}</span>
                                {{-- <img class="img-profile rounded-circle"
                                    src="{{Vite::asset('resources/img/undraw_profile.svg')}}"> --}}
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="javascript:void(0)" href="/perfil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a> --}}
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">{{$title}}</h1>
                    @if ($errors->any())
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    @php
                        $success = session("success");
                    @endphp
                    @if($success)
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <ul>
                                    {{$success}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Hospital Raúl Leoni - 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sessión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Salir" abjo si esta listo para cerrar sessión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form action="{{url('/logout')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" value="logout" class="btn btn-primary">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
