@extends('admin.layout')
@section('content')

<div class="row">
    <div class="card shadow mb-4 col-12">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Calendario</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">

                <input type="text" hidden id="csrfToken" value="{{ csrf_token() }}" >
                <input type="text" hidden id="user" value="{{\Auth::user()}}" >
                <input type="text" hidden id="calendarType" value="scheduleDate" >
                <input type="text" hidden id="selectedDoctor" value="{{$doctorId}}" >
                @if(\Auth::user()->rol == "PATIENT")
                    <input type="text" hidden id="selectedPatient" value="{{$patientId}}" >
                @else
                    <input type="text" hidden id="selectedPatient" value="">
                    <h4>Buscar paciente:</h4>
                    <div class="input-group">
                        <input type="text" id="buscadorPaciente" class="form-control bg-light border-0 small" placeholder="Ingrese el nombre o la identificacion del paciente..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="searchButton">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="list-group w-100" id="listaUsuarios">

                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <br>
            <h2>Paciente: <span id="nombrePaciente"></span></h2>
            <div id="calendar"></div>
        </div>

    </div>
</div>


@endsection
