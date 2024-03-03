@extends('admin.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">


<body class="bg-gradient-primary">
  <div class="container">
  
            <div class="card o-hidden border-0 shadow-lg my-2" height="30">
                
                       
                          <div class="card-group d-flex " >
                          
                               @foreach ($new as $noticia)

                               <div class="col-sm-4">
                                <img src="\imagenes/noticias/{{$noticia->file_name}}" class="card-img-top" height="200" >
                                <div class="card-body">
                                  <h5 class="card-title"><strong>TITULO: </strong>{{$noticia->title}}</h5>
                                  <p class="card-text"><strong>DESCRIPCION: </strong>{{$noticia->description}} </p>
                                  <h5 class="card-text"><small class="text-muted"><strong>AUTOR:</strong>{{$noticia->author_id}}</small>
                                </div>
                                  <div class="d-flex justify-content-center w-20" >
                                    <a href="{{url('editnoticias', $noticia->id)}}"  class="btn btn-primary btn-user" style="margin-left:20px">MODIFICAR</a> <BR>
                                      <form method="POST" action="{{url("/deletenew", $noticia->id)}}">
                                        @csrf
                                        @method('delete')
  
                                        <td><button type="submit" class="btn btn-primary btn-user btn-block" style="margin-left:20px">ELIMINAR</button></td>
                                     </form>
                                    
                                </div>
                                <hr>
                              </div>
                              @endforeach
                     
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
