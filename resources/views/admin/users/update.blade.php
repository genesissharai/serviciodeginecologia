@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="user" method="POST" action="{{url("/$updateType/$user->id")}}" >
                        {{ csrf_field() }}
                        @method('patch')
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control form-control-user" id="nombre" name="name" required value="{{$user->name}}"
                                    placeholder="Nombre">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Apellido</label>
                                <input type="text" class="form-control form-control-user" id="apellido" name="last_name" required value="{{$user->last_name}}"
                                    placeholder="Apellido">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input type="email" class="form-control form-control-user" id="correo" name="email" required value="{{$user->email}}"
                                placeholder="Correo electrónico">
                        </div>

                        <label for="">Cedula</label>
                        <div class="form-group row">
                            <div class="col-3 d-flex align-items-center">
                                <select class="form-control form-select" id="tipo_cedula" name="ci_type" required>
                                    <option value="V-" @if(count(explode("-",$user->ci)) && explode("-",$user->ci)[0] == "V") selected @endif> V </option>
                                    <option value="E-" @if(count(explode("-",$user->ci)) && explode("-",$user->ci)[0] == "E") selected @endif> E </option>
                                </select>
                            </div>
                            <div class="col-9 ml-0 pl-0">
                                <input type="text" class="form-control form-control-user" id="cedula" name="ci" required
                                @if(count(explode("-",$user->ci)) > 1)
                                    value="{{explode("-",$user->ci)[1]}}"
                                @else
                                    value="{{$user->ci}}"
                                @endif
                                        placeholder="Cedula de identidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label for="fecha_nacimiento" class="form-label input-group-text">Fecha de nacimiento</label>
                                </div>
                                <input type="date" class="form-control form-control-user" id="fecha_nacimiento" name="birthdate" required value="{{$user->birthdate}}">
                              </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="">Telefono</label>
                                <input type="text" class="form-control form-control-user" required value="{{$user->phone}}"
                                    id="telefono" name="phone" placeholder="Telefono">
                            </div>
                        </div>
                        @if($updateType == "updateDoctor")
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="">Jerarquia</label>
                                    <select name="doctor_hierarchy_id" class="form-control" id="jerarquia">
                                        @foreach ($jerarquiasDoctor as $jerarquia)
                                            <option value="{{$jerarquia->id}}" @if($user->doctor_hierarchy_id == $jerarquia->id) selected @endif>{{$jerarquia->hierarchy}} - {{$jerarquia->specialty}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            {{-- <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user" required
                                    id="contraseña" name="password" placeholder="password">
                        x    </div> --}}
                            {{-- <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                    id="repetirContraseña" placeholder="Repetir contraseña">
                            </div> --}}
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Actualizar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
