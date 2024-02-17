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
                <input type="text" hidden id="userId" value="{{\Auth::id()}}" >
                <input type="text" hidden id="calendarType" value="scheduleDate" >
                <input type="text" hidden id="selectedDoctor" value="{{$doctorId}}" >
                @if(\Auth::user()->rol == "PATIENT")
                    <input type="text" hidden id="selectedPatient" value="{{$patientId}}" >
                @else
                    <input type="text" hidden id="selectedPatient" value="4" >
                    <div class="input-group">
                        <input type="text" id="Buscador" class="form-control bg-light border-0 small" placeholder="Ingrese el nombre o la identificacion del paciente..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                @endif
                <button type="button" class="btn btn-primary saveCalendarData">Guardar</button>

            </div>

            <br>
            <div id="calendar"></div>
        </div>
        <div class="card-body">
            {{-- <button type="button" class="btn btn-primary" id="logEvents">Log events</button> --}}
            {{-- <button type="button" class="btn btn-primary saveCalendarData">Guardar</button> --}}
        </div>
    </div>
</div>


@endsection
