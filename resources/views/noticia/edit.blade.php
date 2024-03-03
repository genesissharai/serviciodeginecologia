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
                                        <h1 class="h4 text-gray-900 mb-4n  ">¡Agregar Noticia!</h1>
                                    </div>
                                    <Br>

                                    <form class="user" method="POST" action="{{url("/editnoticias", $new->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put');
                                        
                                        <div class="col-lg-12">
                                            <Strong>Titulo de la noticia</Strong>
                                            <input type="text" class="form-control" value="{{$new->title}}" name="tittle">
                                          </div>
                                          <BR>
                                        <div class="row">
                                            <div class="col">
                                              <Strong>Autor de la noticia</Strong>
                                              <input type="text" class="form-control" value="{{$new->slug}}" name="autor">
                                            </div>
                                            <div class="col">
                                                <Strong>Cargar imagen</Strong>
                                                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="imagen">
                                              
                                          </div>
                                        </div>
                                          <BR>
                                                <div class="col-lg-12">
                                                    <Strong>Descripcion de la noticia</Strong>
                                                    <input type="text" class="form-control" value="{{$new->description}}" name="description">
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
