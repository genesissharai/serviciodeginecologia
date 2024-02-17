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

        <!-- Agendar horario disponible doctor -->
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
                        <div class="col-10">
                            No hay citas disponibles...
                        </div>
                        <div class="col-2">
                            <a href="#" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-flag"></i>
                                </span>
                                <span class="text">Agendar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
