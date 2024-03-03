@extends('admin.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">



<body class="bg-gradient-primary">
  <div class="container">
  
            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">


                            <table class="table table-striped table-responsive">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Cedula</th>
                                    <th scope="col">Fecha N</th>
                                    <th scope="col">Gestas</th>
                                    <th scope="col">Fecha Ultima Regla</th>
                                    <th scope="col">Edad gestacional por FUR</th>
                                    <th scope="col">Fecha Primer Eco</th>
                                    <th scope="col">Edad gestacional por FPE</th>
                                    <th scope="col">Tension Arterial</th>
                                    <th scope="col">Altura uterina</th>
                                    <th scope="col">Examenes fisicos</th>
                                    <th scope="col">Conducta</th>
                                    <th scope="col">Operaciones</th>
                                    <th scope="col">Operaciones</th>
                                  </tr>
                                </thead>
                                  @foreach ($morbidities as $morbidity)
                                  <tbody>

                                  <tr>
                                    <th scope="row">{{$contador++}}</th>
                                    <td>{{$morbidity->name}}</td>
                                    <td>{{$morbidity->last_name}}</td>
                                    <td>{{$morbidity->ci}}</td>
                                    <td>{{$morbidity->age}}</td>
                                    <td>{{$morbidity->pregnancies}}</td>
                                    <td>{{$morbidity->fvr}}</td>
                                    <td>{{$morbidity->ev_x_fur}}</td>
                                    <td>{{$morbidity->first_eco}}</td>
                                    <td>{{$morbidity->eg_x_eco}}</td>
                                    <td>{{$morbidity->ta}}</td>
                                    <td>{{$morbidity->au}}</td>
                                    <td>{{$morbidity->physical_exam}}</td>
                                    <td>{{$morbidity->conduct}}</td>

                                    <td> <a class="btn btn-primary btn-user btn-block" href="{{url('editmorbidity', $morbidity->id)}}"><b>MODIFICAR</b></a></td>

                                    <form method="POST" action="{{url("/deletemorby", $morbidity->id)}}">
                                      @csrf
                                      @method('delete')

                                      <td><button type="submit" class="btn btn-primary btn-user btn-block">ELIMINAR</button></td>
                                  </form>
                                    

                                  </tr>
                                </tbody>


                              @endforeach

                            
                              </table>

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
