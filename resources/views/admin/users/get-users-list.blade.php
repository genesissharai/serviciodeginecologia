@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

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
                                            <td>{{$user->hierarchy}}</td>
                                            <td>{{$user->specialty}}</td>
                                        @endif
                                        <td>@if($user->status)Activo @else Inactivo @endif</td>
                                        @if(\Auth::user()->rol !== "PATIENT")
                                            <td>    {{-- Si el usuario logeado es diferente a paciente y si el usuario objetivo es un paciente o el usuario logeado es admin --}}
                                                    {{-- Permitira actualizar al usuario --}}
                                                @if(\Auth::user()->rol !== "PATIENT" && ($user->rol == "PATIENT" || \Auth::user()->rol == "ADMIN"))
                                                    <a href="/update{{ucfirst(strtolower($user->rol))}}/{{$user->id}}" class="btn btn-warning">Actualizar</a>
                                                @endif
                                                @if(\Auth::user()->rol == "DOCTOR" && ($user->rol == "PATIENT"))
                                                    <a href="/administrarExamenesPaciente/{{$user->id}}" class="btn btn-info mt-2" disabled>Examenes</a>
                                                @endif
                                                @if(\Auth::user()->rol == "ADMIN")
                                                    <a href="/cambiarContraseñaUsuario/{{$user->id}}" class="btn btn-info mt-2" disabled>Cambiar contraseña</a>
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
