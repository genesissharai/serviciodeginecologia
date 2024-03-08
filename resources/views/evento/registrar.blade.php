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
                                    <div class="text-center ">
                                        <h1 class="h4 text-gray-900 mb-4n  ">¡Agregar Evento!</h1>
                                    </div>
                                    <Br>

                                    <form class="user" method="POST" action="{{url("/registrareventos")}}" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="col-lg-12">
                                            <Strong>Registrar imagen</Strong>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="imagen">
                                          </div>
                                          <BR>
                                        <div class="row">
                                            <div class="col">
                                              <Strong>Autor del evento</Strong>
                                              <input type="text" class="form-control" value="" name="autor">
                                            </div>
                                        </div>
                                        <BR>
                                        <div class="row">
                                            <div class="col">
                                              <Strong>Titulo del evento</Strong>
                                              <input type="text" class="form-control" value="" name="tittle">
                                            </div>
                                        </div>
                                          <BR>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">Informacion del evento</span>
                                                </div>
                                                <textarea class="form-control" aria-label="With textarea" name="description"></textarea>
                                              </div>
                                                  <BR>

                                        <div class="d-flex justify-content-center w-40" >
                                            <button type="submit" class="btn btn-primary btn-user" justify-content= "center">
                                            REGISTRAR
                                        </button>
                                        </div>
                                    <hr>

                                    </form>
                                </div>
                            </div>


                        </div>

                        <div class="col">
                            <Strong>ULTIMOS EVENTOS</Strong>
                          </div>
                      <BR>
                      <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead>
                                <BR>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">OPCIONES</th>
                                </tr>
                                <BR>
                            </thead>
                            <tbody>
                                @foreach ($noticia as $item)
                                
                                <tr>
                                <th scope="">{{$contador}}</th>
                                <td>{{$item->title}}</td>
                                <td>{{$item->author}}</td>
                                <td>{{$item->description}}</td>
                                <td>
                                    <a href="{{url('/listeventos', $item->id)}}"  class="btn btn-primary btn-user" style="margin-left:5px">Abrir</a> 
                                    <BR>
                                    <BR>
                                
                        
                                    <a href="{{url('/updateevents',$item->id)}}" class="btn btn-primary btn-user" style="margin-left:5px">Editar</a> 
                                    <BR>
                                    <BR>
                                    
                                        <form method="POST" action="{{url("/deleteevents",$item->id)}}">
                                            @csrf
                                            @method('delete')
      
                                            <button type="submit" class="btn btn-primary btn-user btn-block" style="margin-left:5px">Eliminar</button>
                                         </form>

                                </td>
                            </tr>
                            @php
                                $contador++
                            @endphp
                                
                                    
                                @endforeach
                                
                            </tbody>
                        </table>
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
