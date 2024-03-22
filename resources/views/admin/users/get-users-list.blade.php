@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <form action="{{$action}}" method="GET">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" name="name" id="name" @if(isset($searchTerms["name"])) value="{{$searchTerms["name"]}}"  @endif>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="">Correo</label>
                                    <input type="text" class="form-control" name="email" @if(isset($searchTerms["email"])) value="{{$searchTerms["email"]}}"  @endif>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="">Cedula</label>
                                    <input type="text" class="form-control" name="ci" @if(isset($searchTerms["ci"])) value="{{$searchTerms["ci"]}}"  @endif>
                                </div>
                                @if($rol == "DOCTOR")
                                    <div class="col-12 col-md-6">
                                        <label for="">Jerarquia</label>
                                        <select name="doctor_hierarchy_id" class="form-control" id="jerarquia">
                                                <option value="">Seleccionar jerarquia</option>
                                            @foreach ($jerarquiasDoctor as $jerarquia)
                                                <option value="{{$jerarquia->id}}" @if(isset($searchTerms["doctor_hierarchy_id"]) && $searchTerms["doctor_hierarchy_id"] == $jerarquia->id) selected @endif >{{$jerarquia->hierarchy}} - {{$jerarquia->specialty}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                            <button class="btn btn-info mt-3">Buscar</button>
                        </form>
                    </div>
                    <hr>

                    @if (\Auth::user()->rol != "PATIENT")
                        @if(($rol == "PATIENT") || (\Auth::user()->rol == "ADMIN"))
                            <a class="btn btn-primary mb-3" href="{{$registerType}}">Nuevo usuario</a>
                        @endif
                    @endif

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
                                @if((\Auth::user()->rol == "DOCTOR") || ($rol == "DOCTOR" && \Auth::user()->rol == "ADMIN"))
                                    <th>Asistencias a quirofano</th>
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
                                            <td>{{$user->doctorHierarchy->specialty ?? ''}}</td>
                                            <td>{{$user->doctorHierarchy->hierarchy ?? ''}}</td>
                                        @endif
                                        @if((\Auth::user()->rol == "DOCTOR") || ($rol == "DOCTOR" && $user->doctorHierarchy->resident == 1 && \Auth::user()->rol == "ADMIN"))
                                            @if($user->doctorHierarchy->resident == 1)
                                                <td>{{$user->operatingRoomAttendanceQuantity() ?? 0}}</td>
                                            @else
                                                <td>NO APLICA</td>
                                            @endif
                                        @endif
                                        <td>@if($user->status)Activo @else Inactivo @endif</td>
                                        @if(\Auth::user()->rol !== "PATIENT")
                                            <td>    {{-- Si el usuario logeado es diferente a paciente y si el usuario objetivo es un paciente o el usuario logeado es admin --}}
                                                    {{-- Permitira actualizar al usuario --}}
                                                @if(\Auth::user()->rol == "DOCTOR" && $user->rol == "PATIENT")
                                                    <div class="col-12">
                                                        <a href="/referenciasPaciente/{{$user->id}}" class="btn btn-sm btn-info mt-2" >Examenes</a>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="/informeMedicoPaciente/{{$user->id}}" class="btn btn-sm btn-info mt-2" >Informes Medicos</a>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="/historiaClinicaPaciente/{{$user->id}}" class="btn btn-sm btn-info mt-2" >Historia Clinica</a>
                                                    </div>
                                                @endif
                                                @if(\Auth::user()->rol !== "PATIENT" && ($user->rol == "PATIENT" || \Auth::user()->rol == "ADMIN"))
                                                    <div class="col-12">
                                                        <a href="/update{{ucfirst(strtolower($user->rol))}}/{{$user->id}}" class="btn btn-sm btn-warning mt-2">Actualizar @if($user->rol == "PATIENT") paciente @else usuario @endif</a>
                                                    </div>
                                                    <div class="col-12">
                                                        <form action="/deleteUser" method="post">
                                                            @csrf()
                                                            @method('delete')
                                                            <input type="text" name="user_id" hidden value="{{$user->id}}" id="">
                                                            <button type="submit" class="btn btn-sm btn-danger mt-2">Eliminar @if($user->rol == "PATIENT") paciente @else usuario @endif</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                @if(\Auth::user()->rol == "ADMIN" ||  ($user->rol == "PATIENT" && \Auth::user()->rol != "PATIENT"))
                                                    <div class="col-12">
                                                        <a href="/changeUserPassword/{{$user->id}}" class="btn btn-sm btn-info mt-2" disabled>Cambiar contraseña</a>
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
