@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header p-3"><h6 class="m-0 font-weight-bold text-primary">Filtrar</h6></div>
            <div class="card-body">
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
                        <div class="col-12 col-md-6">
                            <label for="">Jerarquia</label>
                            <select name="doctor_hierarchy_id" class="form-control" id="jerarquia">
                                    <option value="">Seleccionar jerarquia</option>
                                @foreach ($jerarquiasDoctor as $jerarquia)
                                    <option value="{{$jerarquia->id}}" @if(isset($searchTerms["doctor_hierarchy_id"]) && $searchTerms["doctor_hierarchy_id"] == $jerarquia->id) selected @endif >{{$jerarquia->hierarchy}} - {{$jerarquia->specialty}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- @if($rol == "DOCTOR")
                        @endif --}}
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Desde fecha de inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" @if(isset($searchTerms["fecha_inicio"])) value="{{$searchTerms["fecha_inicio"]}}" @endif>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Hasta fecha final</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" @if(isset($searchTerms["fecha_fin"])) value="{{$searchTerms["fecha_fin"]}}" @endif>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary" type="submit">Buscar</button>
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#attedanceModal" >Marcar asistencia</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Proximas Citas -->
        <div class="col-12">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de asistencia</h6>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            {{$attendances->links()}}
                            <div class="table-responsive w-100">
                                <table class="table table-bordered">
                                    <thead>
                                        <th style="width: 10%;">
                                            Fecha
                                        </th>
                                        <th style="width: 10%;">
                                            Medico
                                        </th>
                                        <th style="width: 10%;">Especialidad</th>
                                        <th style="width: 10%;">Jerarquia</th>
                                        <th style="width: 10%;">CI</th>
                                        <th style="width: 10%;">Correo</th>
                                        <th style="width: 10%;"></th>
                                    </thead>
                                    @forelse ($attendances as $attendance)
                                        <tr>
                                            <td colspan=""><b>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format("Y-m-d") }}</b></td>
                                            <td colspan=""><b>{{$attendance->doctor->fullName()}}</b></td>
                                            <td colspan="">{{$attendance->doctor->doctorHierarchy->specialty}}</td>
                                            <td colspan="">{{$attendance->doctor->doctorHierarchy->hierarchy}}</td>
                                            <td colspan="">{{$attendance->doctor->ci}}</td>
                                            <td colspan="">{{$attendance->doctor->email}}</td>
                                            <td colspan="">
                                            <form action="/asistencia_quirofano" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="text" value="{{$attendance->id}}" hidden name="attendance_id">
                                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                            </form>
                                            </td>

                                        </tr>
                                    @empty
                                        <td colspan="">No hay asistencias...</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                </table>
                            </div>
                            {{$attendances->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div>

        <!-- Modal -->
        <div class="modal fade" id="attedanceModal" tabindex="-1" aria-labelledby="attedanceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="attedanceModalLabel">Marcar asistencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="/asistencia_diaria" method="post">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Doctor</label>
                                    <select required name="user_id" id="" required class="form-control">
                                        <option disabled value="" selected>Seleccione</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->fullName()}} - {{$doctor->ci}} - {{$doctor->doctorHierarchy->hierarchy}} {{$doctor->doctorHierarchy->specialty}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Fecha</label>
                                    <input type="date" required id="attendance_date_add" value="{{date('Y-m-d')}}" name="attendance_date" class="form-control">
                                </div>
                                <div class="col-12">

                                    <button type="submit" class="btn btn-primary mt-2">Marcar asistencia</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
            </div>
        </div>

    </div>


@endsection
