@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <form action="{{$action}}" method="GET">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" name="name" @if(isset($searchTerms["name"])) value="{{$searchTerms["name"]}}"  @endif>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="">Correo</label>
                                    <input type="text" class="form-control" name="email" @if(isset($searchTerms["email"])) value="{{$searchTerms["email"]}}"  @endif>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="">Cedula</label>
                                    <input type="text" class="form-control" name="ci" @if(isset($searchTerms["ci"])) value="{{$searchTerms["ci"]}}"  @endif>
                                </div>
                                @if($rol == "DOCTOR")
                                    <div class="col-12 col-md-6">
                                        <label for="">Jerarquia</label>
                                        <input type="text" class="form-control" name="hierarchy" @if(isset($searchTerms["hierarchy"])) value="{{$searchTerms["hierarchy"]}}"  @endif>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="">Especialidad</label>
                                        <input type="text" class="form-control" name="specialty" @if(isset($searchTerms["specialty"])) value="{{$searchTerms["specialty"]}}"  @endif>
                                    </div>
                                @endif
                            </div>
                            <button class="btn btn-info mt-3">Buscar</button>
                        </form>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        {{$users->links()}}

                        <table class="table table-striped table-bordered">
                            <thead>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>CI</th>
                                <th>Telefono</th>
                                <th>Fecha de nacimiento</th>
                                @if($rol == "DOCTOR")
                                    <th>Especialidad</th>
                                    <th>Jerarquia</th>
                                @endif
                                <th>Estatus</th>
                                @if(\Auth::user()->rol !== "PATIENT")
                                    <th>Acciones</th>
                                @endif
                            </thead>

                            <tbody>

                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{$user->fullName()}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->ci}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->birthdate}}</td>
                                        @if($rol == "DOCTOR")
                                            <td>{{$user->specialty}}</td>
                                            <td>{{$user->hierarchy}}</td>
                                        @endif
                                        <td>@if($user->status)Activo @else Inactivo @endif</td>
                                        @if(\Auth::user()->rol !== "PATIENT")
                                            <td>    {{-- Si el usuario logeado es diferente a paciente y si el usuario objetivo es un paciente o el usuario logeado es admin --}}
                                                    {{-- Permitira actualizar al usuario --}}
                                                @if(\Auth::user()->rol !== "PATIENT" && ($user->rol == "PATIENT" || \Auth::user()->rol == "ADMIN"))
                                                    <div class="col-12">
                                                        <a href="/update{{ucfirst(strtolower($user->rol))}}/{{$user->id}}" class="btn btn-warning">Actualizar</a>
                                                    </div>
                                                @endif
                                                @if(\Auth::user()->rol == "DOCTOR" && ($user->rol == "PATIENT"))
                                                    <div class="col-12">
                                                        <a href="/administrarExamenesPaciente/{{$user->id}}" class="btn btn-sm btn-info mt-2" disabled>Examenes</a>
                                                    </div>
                                                @endif
                                                @if(\Auth::user()->rol == "ADMIN")
                                                    <div class="col-12">
                                                        <a href="/cambiarContraseñaUsuario/{{$user->id}}" class="btn btn-sm btn-info mt-2" disabled>Cambiar contraseña</a>
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                            {{$users->links()}}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
