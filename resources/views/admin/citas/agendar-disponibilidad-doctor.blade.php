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
                <input type="text" hidden id="calendarType" value="doctorAvailability" >
                <input type="text" hidden id="selectedDoctor" value="{{$doctorId}}" >
                <button type="button" class="btn btn-primary saveCalendarData">Guardar</button>

            </div>

            <br>
            <div id="calendar"></div>
        </div>
        <div class="card-body">
            {{-- <button type="button" class="btn btn-primary" id="logEvents">Log events</button> --}}
            <button type="button" class="btn btn-primary saveCalendarData">Guardar</button>
        </div>
    </div>
</div>


@endsection
