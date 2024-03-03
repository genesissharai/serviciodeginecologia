@extends('admin.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">



<body class="bg-gradient-primary">

    <div class="container">



        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12 pr-4 py-1 d-flex justify-content-end">
                                <a role="button" href="{{url('/dashboard')}}" class="small color-info">
                                    <i class="far fa-arrow-to-left"></i>
                                    <u>Volver al inicio</u></a>
                            </div>
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">¡Registro del paciente!</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{url("/registrarmorbilidad")}}">
                                        {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col">
                                            <Strong>Nombre</Strong>
                                            <input type="text" class="form-control form-control-user"
                                                id="name" name="name"
                                                placeholder="">
                                        </div>
                                        <div class="col">
                                            <Strong>Apellido</Strong>
                                            <input type="text" class="form-control form-control-user"
                                                id="last" name="last_name"
                                                placeholder="">
                                        </div>
                                    </div>
                                    <BR>
                                    <div class="row">
                                        <div class="col">
                                            <Strong>Cedula</Strong>
                                            <input type="text" class="form-control form-control-user"
                                                id="cedula" name="ci"
                                                placeholder="Ejemplo V-00000000">
                                        </div>
                                        <div class="col">
                                            <Strong>Fecha de nacimiento</Strong>
                                            <input type="date" class="form-control form-control-user" name="fn"
                                                id="fn" placeholder="DD/MM/AAAA">
                                        </div>
                                    </div>
                                    <BR>
                                    <div class="row">
                                        <div class="col">
                                            <Strong>Cantidad de embarazos</Strong>
                                            <input type="int" class="form-control form-control-user"
                                                id="pregnancies" aria-describedby="" name="pregnancies"
                                                placeholder="">
                                        </div>
                                        <div class="col">
                                            <Strong>Fecha de ultima regla</Strong>
                                            <input type="date" class="form-control form-control-user" name="fvr"
                                                id="fvr" placeholder="DD/MM/AAAA">
                                        </div>
                                    </div>
                                    <BR>
                                    <div class="row">
                                        <div class="col">
                                            <Strong>Edad gestacional</Strong>
                                            <input type="int" class="form-control form-control-user" name="ev_x_fur"
                                                id="ev_x_fur" placeholder="">
                                        </div>
                                        <div class="col">
                                            <Strong>Fecha de primer eco</Strong>
                                            <input type="date" class="form-control form-control-user" name="first_eco"
                                                id="first_eco" placeholder="DD/MM/AAAA">
                                        </div>
                                    </div>
                                    <BR>
                                    <div class="row">
                                        <div class="col">
                                            <Strong>Edad gestacion por ultimo eco</Strong>
                                            <input type="int" class="form-control form-control-user" name="eg_x_eco"
                                                id="eg_x_eco" placeholder="">
                                        </div>
                                        <div class="col">
                                            <Strong>Tension arterial</Strong>
                                            <input type="int" class="form-control form-control-user" name="ta"
                                                id="ta" placeholder="">
                                        </div>
                                    </div>
                                    <BR>
                                    <div class="row">
                                        <div class="col">
                                            <Strong>Altura uterina</Strong>
                                            <input type="int" class="form-control form-control-user" name="au"
                                                id="au" placeholder="">
                                        </div>
                                        <div class="col">
                                            <Strong>Examen Fisico</Strong>
                                            <input type="int" class="form-control form-control-user" name="physical_exam"
                                                id="physical_exam" placeholder="">
                                        </div>
                                    </div>
                                    <BR>
                                        <div class="col">
                                            <Strong>Conducta</Strong>
                                            <input type="int" class="form-control form-control-user" name="conduct"
                                                id="conduct" placeholder="">
                                        </div>

                                        </div>
                                    
                
                                        <div class="d-flex justify-content-center w-40" >
                                            <button type="submit" class="btn btn-primary btn-user" justify-content= "center">
                                             REGISTRAR
                                         </button>
                                         </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="">¡Registrarse!</a>


                                    </div>
                                </div>
                            </div>


                        </div>
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

  
@endsection
