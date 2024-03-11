@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(\Auth::user()->rol == "DOCTOR")
                    <a href="/crearReferenciaPaciente/{{$patient->id}}" class="btn btn-primary mb-2">Agregar referencia</a>
                @endif
                <div class="table-responsive">
                    {{$references->links()}}

                    <table class="table table-striped table-bordered">
                        <thead>
                            <th style="width: 10%;">Fecha creado</th>
                            <th style="width: 10%;">Mandado por</th>
                            <th style="width: 30%;">Referencia</th>
                            <th style="width: 30%;">Resultado</th>
                            @if(\Auth::user()->rol == "DOCTOR")
                                <th>{{-- Acciones --}}</th>
                            @endif

                        </thead>

                        <tbody>

                            @forelse ($references as $reference)
                                <tr>

                                    {{-- <td>{{\Carbon\Carbon::parse($reference->created_at)->format("y-m-d h:i A")}}</td> --}}
                                    <td>{{\Carbon\Carbon::parse($reference->created_at)->format("Y-m-d")}}</td>
                                    <td>{{$reference->doctor->fullName()}}</td>
                                    <td>
                                        <p style="max-height: 200px; overflow-y: auto; white-space: pre-wrap;" class="fr-view">{!!$reference->exams!!}</p>
                                    </td>
                                    <td>
                                        @if(isset($reference->resultado))
                                            <p style="max-height: 200px; overflow-y: auto; white-space: pre-wrap;">{!!$reference->resultado->result!!}</p>
                                        @endif
                                    </td>
                                    @if(\Auth::user()->rol == "DOCTOR")
                                        <td>
                                            <a href="/modificarReferenciaPaciente/{{$reference->id}}" class="btn btn-warning btn-sm" type="button">Modificar referencia</a>
                                            <br>
                                            @if(isset($reference->resultado))
                                                <a href="/modificarResultadoExamenPaciente/{{$reference->resultado->id}}" class="btn btn-warning btn-sm mt-2" type="button">Modificar resultado</a>
                                            @else
                                                <a href="/registrarResultadoExamenPaciente/{{$reference->id}}" class="btn btn-warning btn-sm mt-2" type="button">Agregar resultado</a>
                                            @endif
                                            <br>
                                            <form action="/eliminarReferenciaPaciente/{{$reference->id}}" method="POST" class="mt-2">
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
                        {{$references->links()}}
                </div>


            </div>
        </div>
    </div>
</div>

@endsection
