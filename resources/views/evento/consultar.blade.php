@extends('admin.layout')

@section('content')

<!DOCTYPE html>
<html lang="en">


<body class="bg-gradient-primary">
  <div class="container">

    <div class="row justify-content-center">
        
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                    

                        <div class="col-sm">
                         <img src="\imagenes/noticias/{{$new->file_name}}" class="card-img-top" height="200" >
                         <div class="card-body">
                           <h5 class="card-title"><strong>TITULO: </strong>{{$new->title}}</h5>
                           <p class="card-text"><strong>DESCRIPCION: </strong>{{$new->description}} </p>
                           <h5 class="card-text"><small class="text-muted"><strong>AUTOR:</strong>{{$new->author}}</small>
                         </div>
                         <br>
                       </div>
                       <div class="d-flex justify-content-center w-20" >
                        <a href="{{url("/updateevents",$new->id)}}"  class="btn btn-primary btn-user" style="margin-left:20px">MODIFICAR</a> <BR>
                          <form method="POST" action="{{url("/deletenew", $new->id)}}">
                            @csrf
                            @method('delete')

                            <td><button type="submit" class="btn btn-primary btn-user btn-block" style="margin-left:20px">ELIMINAR</button></td>
                         </form>
                        
                        </div>
                        <br>



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
