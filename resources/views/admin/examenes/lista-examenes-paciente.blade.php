@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(\Auth::user()->rol == "DOCTOR")
                    <a href="/crearExamenPaciente/{{$patient->id}}" class="btn btn-primary mb-2">Nuevo examen</a>
                @endif
                <div class="table-responsive">
                    {{$references->links()}}

                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Fecha</th>
                            <th>Examen</th>
                            <th>Mandado por</th>
                            @if(\Auth::user()->rol == "DOCTOR")
                                <th>{{-- Acciones --}}</th>
                            @endif

                        </thead>

                        <tbody>

                            @forelse ($references as $reference)
                                <tr>

                                    {{-- <td>{{\Carbon\Carbon::parse($reference->created_at)->format("y-m-d h:i A")}}</td> --}}
                                    <td>{{\Carbon\Carbon::parse($reference->created_at)->format("y-m-d")}}</td>
                                    <td>{{$reference->doctor->fullName()}}</td>
                                    <td>
                                        <p style="max-height: 200px; overflow-y: auto; white-space: pre-wrap;">{{$reference->exams}}</p>
                                    </td>
                                    @if(\Auth::user()->rol == "DOCTOR")
                                        <td>
                                            <a href="/modificarExamenPaciente/{{$reference->id}}" class="btn btn-warning btn-sm" type="button">Modificar</a>
                                            <br>
                                            <form action="/eliminarExamenPaciente/{{$reference->id}}" method="POST" class="mt-2">
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
