@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(\Auth::user()->rol == "DOCTOR")
                    <a href="/crearInformeMedicoPaciente/{{$patient->id}}" class="btn btn-primary mb-2">Agregar referencia</a>
                @endif
                <div class="table-responsive">
                    {{$medicalReports->links()}}

                    <table class="table table-bordered">
                        <thead>
                            <th style="width: 10%;">Fecha creado</th>
                            {{-- <th style="width: 10%;">Fecha de consulta</th> --}}
                            <th style="width: 10%;">Elaborado por</th>
                            <th style="width: 60%;">Informacion del informe medico</th>
                            @if(\Auth::user()->rol == "DOCTOR")
                                <th>{{-- Acciones --}}</th>
                            @endif

                        </thead>

                        <tbody>

                            @forelse ($medicalReports as $report)
                                <tr>

                                    {{-- <td>{{\Carbon\Carbon::parse($reference->created_at)->format("y-m-d h:i A")}}</td> --}}
                                    <td>{{\Carbon\Carbon::parse($report->created_at)->format("Y-m-d")}}</td>
                                    {{-- <td>{{\Carbon\Carbon::parse($report->created_at)->format("Y-m-d")}}</td> --}}
                                    <td>{{$report->doctor->fullName()}}</td>
                                    <td>
                                        <p><b>{{$report->title}}</b></p>
                                        <hr>
                                        <p style="max-height: 200px; overflow-y: auto; white-space: pre-wrap;" class="fr-view">{!!$report->report!!}</p>
                                    </td>
                                    @if(\Auth::user()->rol == "DOCTOR")
                                        <td>
                                            <a href="/modificarInformeMedicoPaciente/{{$report->id}}" class="btn btn-warning btn-sm" type="button">Modificar Informe</a>
                                            <br>
                                            <form action="/eliminarInformeMedicoPaciente/{{$report->id}}" method="POST" class="mt-2">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-danger btn-sm" >Eliminar</button>
                                            </form>
                                        </td>
                                    @endif


                                </tr>
                            @empty
                                <tr>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                        {{$medicalReports->links()}}
                </div>


            </div>
        </div>
    </div>
</div>

@endsection