<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hospital Raúl Leoni - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{Vite::asset('resources/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{Vite::asset('resources/scss/sb-admin-2.scss')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-12 pr-4 py-1 d-flex justify-content-end">
                        <a role="button" href="{{url('/')}}" class="small color-info">
                            <i class="far fa-arrow-to-left"></i>
                            <u>Volver al inicio</u></a>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">¡Registrarse!</h1>
                            </div>

                            <form class="user" method="POST" action="{{url("/$registerType")}}" >
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="nombre" name="name" required
                                            placeholder="Nombre">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="apellido" name="last_name" required
                                            placeholder="Apellido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="correo" name="email" required
                                        placeholder="Correo electrónico">
                                </div>

                                <div class="form-group row">
                                    <div class="col-3 d-flex align-items-center">
                                        <select class="form-control form-select" id="tipo_cedula" name="ci_type" required>
                                            <option value="V-" selected> V </option>
                                            <option value="J-"> J </option>
                                            <option value="E-"> E </option>
                                        </select>
                                    </div>
                                    <div class="col-9 ml-0 pl-0">
                                        <input type="text" class="form-control form-control-user" id="cedula" name="ci" required
                                                placeholder="Cedula de identidad">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label for="fecha_nacimiento" class="form-label input-group-text">Fecha de nacimiento</label>
                                        </div>
                                        <input type="date" class="form-control form-control-user" id="fecha_nacimiento" name="birthdate" required>
                                      </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" required
                                            id="telefono" name="phone" placeholder="Telefono">
                                    </div>
                                </div>
                                @if($registerType == "registerDoctor")
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" required
                                                id="especialidad" name="specialty" placeholder="Especialidad">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" required
                                                id="jerarquia" name="hierarchy" placeholder="Jerarquia">
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" required
                                            id="contraseña" name="password" placeholder="password">
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="repetirContraseña" placeholder="Repetir contraseña">
                                    </div> --}}
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Registrarse
                                </button>
                            </form>
                            <hr>
                            {{-- <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div> --}}
                            <div class="text-center">
                                <a class="small" href="{{url("/$loginType")}}">¿Ya tiene una cuenta? ¡Inicie sesion!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{Vite::asset('resources/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{Vite::asset('resources/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{Vite::asset('resources/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{Vite::asset('resources/js/sb-admin-2.min.js')}}"></script>
</body>

</html>
