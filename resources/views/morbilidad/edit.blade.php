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
                                <a role="button" href="{{url('/')}}" class="small color-info">
                                    <i class="far fa-arrow-to-left"></i>
                                    <u>Volver al inicio</u></a>
                            </div>
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">¡Modificar datos del paciente!</h1>
                                    </div>


                                    <form class="user" method="POST" action="{{url("/editmorbidity", $morbidities->id)}}">
                                        @csrf
                                        @method('put');

                                        <div class="row">
                                          <div class="col">
                                            <Strong>Nombre</Strong>
                                            <input type="text" class="form-control" value="{{$morbidities->name}}" name="name">
                                          </div>
                                          <div class="col">
                                            <Strong>Apellido</Strong>
                                            <input type="text" class="form-control" value="{{$morbidities->last_name}}" name="last_name">
                                          </div>
                                        </div>
                                         <hr>
                                         <div class="row">
                                            <div class="col">
                                            <Strong>Cedula</Strong>
                                              <input type="text" class="form-control" value="{{$morbidities->ci}}" name="cedula">
                                            </div>
                                            <div class="col">
                                                <Strong>Fecha de nacimiento</Strong>
                                              <input type="date" class="form-control" value="{{$morbidities->age}}" name="fn">
                                            </div>
                                          </div>
                                          <hr>
                                          <div class="row">
                                             <div class="col">
                                                <Strong>Gestas</Strong>
                                               <input type="text" class="form-control" value="{{$morbidities->pregnancies}}" name="pregnancies">
                                             </div>
                                             <div class="col">
                                                <Strong>Fecha de ultima regla</Strong>
                                               <input type="date" class="form-control" value="{{$morbidities->fvr}}" name="fvr">
                                             </div>
                                           </div>
                                           <hr>
                                           <div class="row">
                                              <div class="col">
                                                <Strong>Edad gestacional por FUR</Strong>
                                                <input type="text" class="form-control" value="{{$morbidities->ev_x_fur}}" name="ev_x_fur">
                                              </div>
                                              <div class="col">
                                                <Strong>Fecha de ultimo eco</Strong>
                                                <input type="date" class="form-control" value="{{$morbidities->first_eco}}" name="first_eco">
                                              </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                               <div class="col">
                                                <Strong>Edad gestacional por FUE</Strong>
                                                 <input type="text" class="form-control" value="{{$morbidities->eg_x_eco}}" name="eg_x_eco">
                                               </div>
                                               <div class="col">
                                                <Strong>Tension Arterial</Strong>
                                                 <input type="text" class="form-control" value="{{$morbidities->ta}}" name="ta">
                                               </div>
                                             </div>
                                             <hr>
                                             <div class="row">
                                             <div class="col-lg-4">
                                                <Strong>Altura uterina</Strong>
                                                <input type="text" class="form-control" value="{{$morbidities->au}}" name="au">
                                              </div>
                                              <div class="col">
                                                <Strong>Examenes Fisicos</Strong>
                                                 <input type="text" class="form-control" value="{{$morbidities->physical_exam}}" name="physical_exam">
                                               </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                   <Strong>Conducta</Strong>
                                                   <input type="text" class="form-control" value="{{$morbidities->conduct}}" name="conduct">
                                                 </div>
                                               </div>
                                               <hr>
                                               <div class="d-flex justify-content-center w-40" >
                                               <button type="submit" class="btn btn-primary btn-user" justify-content= "center">
                                                MODIFICAR
                                            </button>
                                            </div>
                                      </form>
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
