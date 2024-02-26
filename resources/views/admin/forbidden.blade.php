
<div class="container-fluid">
    <h1 class="text-center">
        No tienes los permisos necesarios.
    </h1>
    <div
        class="row justify-content-center align-items-center g-2"
    >
        <div class="col">
            @if(\Auth::id())
                <a href="{{url('/dashboard')}}">Volver</a>
            @else
                <a href="{{url('/')}}">Volver</a>
            @endif
        </div>
    </div>

</div>
