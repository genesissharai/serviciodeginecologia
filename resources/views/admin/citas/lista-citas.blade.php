@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="card shadow mb-4 w-100">
            <div class="card-header p-3"><h6 class="m-0 font-weight-bold text-primary">Filtrar</h6></div>
            <div class="card-body">
                <form action="{{$action}}" method="GET">
                    <input type="text" hidden value="1" name="filtrar">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class="form-label">Desde fecha de inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" @if(isset($searchTerms["fecha_inicio"])) value="{{$searchTerms["fecha_inicio"]}}" @endif>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class="form-label">Hasta fecha final</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" @if(isset($searchTerms["fecha_fin"])) value="{{$searchTerms["fecha_fin"]}}" @endif>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Proximas Citas -->
        <div class="col-12">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de citas</h6>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            {{$schedules->links()}}
                            <div class="table-responsive w-100">
                                <table class="table table-striped">
                                    <thead>
                                        <th>
                                            Fecha
                                        </th>
                                        @if(\Auth::user()->rol != "PATIENT")
                                            <th>
                                                Paciente
                                            </th>
                                        @endif
                                        <th>
                                            Medico
                                        </th>
                                        <th>
                                            Estado
                                        </th>
                                        <th>

                                        </th>
                                    </thead>
                                    @forelse ($schedules as $schedule)
                                        <tr>
                                            <td colspan="">{{ \Carbon\Carbon::parse($schedule->consultation_date)->format("Y-m-d h:i A") }}</td>
                                            @if(\Auth::user()->rol != "PATIENT")
                                                <td colspan="">{{$schedule->patient->fullName()}}</td>
                                            @endif
                                            <td colspan="">{{$schedule->doctor->fullName()}}</td>
                                            <td colspan="">
                                                @if($schedule->status == "CANCELED") Cancelada @endif
                                                @if($schedule->status == "PENDING") Pendiente @endif
                                                @if($schedule->status == "ATTENDED") Atendida @endif
                                                @if($schedule->status == "UNATTENDED") Sin atender @endif
                                            </td>
                                            <td colspan="">
                                                @if($schedule->status == "PENDING")
                                                    @if(\Auth::user()->rol !== "PATIENT")
                                                        <form id="marcarCitaAsistida-{{$schedule->id}}" data-id={{$schedule->id}} action="/marcarCitaAsistida" method="POST">
                                                            @method('PATCH')
                                                            @csrf
                                                            <input type="text" name="id" hidden value={{$schedule->id}}>
                                                            <button type="submit" class="btn btn-sm mb-2 btn-success btnCitaAsistida" data-id={{$schedule->id}} id="btnCitaAsistida-{{$schedule->id}}" value="btnCitaAsistida-{{$schedule->id}}">Marcar asistida</button>
                                                        </form>
                                                        <form id="marcarCitaNoAtendida-{{$schedule->id}}" data-id={{$schedule->id}} action="/marcarCitaNoAtendida" method="POST">
                                                            @method('PATCH')
                                                            @csrf
                                                            <input type="text" name="id" hidden value={{$schedule->id}}>
                                                            <button type="submit" class="btn btn-sm mb-2 btn-success btnCitaNoAsistida" data-id={{$schedule->id}} id="btnCitaNoAsistida-{{$schedule->id}}" value="btnCitaNoAsistida-{{$schedule->id}}">Marcar no asistida</button>
                                                        </form>
                                                    @endif
                                                    <form id="cancelarCita-{{$schedule->id}}" data-id={{$schedule->id}} action="/cancelarCita" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="text" name="id" hidden value={{$schedule->id}}>
                                                        <button type="button" class="btn btn-sm mb-2 btn-danger btnCancelarCita" data-id={{$schedule->id}} id="btnCancelarCita-{{$schedule->id}}" value="btnCancelarCita-{{$schedule->id}}">Cancelar</button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <td colspan="">No hay citas disponibles...</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="{{url('/agendarCita')}}" class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-flag"></i>
                                                </span>
                                                <span class="text">Agendar</span>
                                            </a>
                                        </td>
                                    @endforelse
                                </table>
                            </div>
                            {{$schedules->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
