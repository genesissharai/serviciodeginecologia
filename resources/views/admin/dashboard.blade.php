@extends('admin.layout')

@section('content')

    <div class="row">
        <!-- Agendar citas -->
        <a href="{{url('/agendarCita')}}" class="col-12 col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-primary text-uppercase">
                                Agendar Citas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300 mb-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <!-- Ver citas -->
        @if (\Auth::user()->rol == "PATIENT")

            <a href="{{url('dashboard')}}" class="col-12 col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 font-weight-bold text-primary text-uppercase">
                                    Mis citas</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300 mb-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endif

        <!-- Agendar horario disponible doctor -->
        @if (\Auth::user()->rol !== "PATIENT")
            <a href="{{url('/agendarDisponibilidad')}}" class="col-12 col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 font-weight-bold text-primary text-uppercase">
                                    disponibilidad de doctor</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300 mb-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        @endif
    </div>

    <div class="row">
        <!-- Proximas Citas -->
        <div class="card shadow mb-4 w-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Proximas Citas</h6>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Paciente
                                    </th>
                                    <th>
                                        Medico
                                    </th>
                                    <th>

                                    </th>
                                </thead>
                                @forelse ($nextSchedules as $schedule)
                                    <tr>
                                        <td colspan="">{{ \Carbon\Carbon::parse($schedule->date)->format("y-m-d h:i A") }}</td>
                                        <td colspan="">{{$schedule->patient->fullName()}}</td>
                                        <td colspan="">{{$schedule->doctor->fullName()}}</td>
                                        <td colspan="">
                                                <form id="cancelarCita-{{$schedule->id}}" data-id={{$schedule->id}} action="/cancelarCita" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="text" hidden value={{$schedule->id}}>
                                                    <button type="button" class="btn btn-danger btnCancelarCita" data-id={{$schedule->id}} id="btnCancelarCita-{{$schedule->id}}" value="btnCancelarCita-{{$schedule->id}}">Cancelar</button>
                                                </form>
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
                                {{$nextSchedules->links()}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
