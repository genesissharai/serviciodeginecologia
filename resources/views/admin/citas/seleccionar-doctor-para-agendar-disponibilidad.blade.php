@extends('admin.layout')
@section('content')

<div class="row">
    <div class="card shadow mb-4 col-12">

        <div class="card-body">
            <div class="mb-3">
                <div class="table-responsive">
                    {{$doctor_list->links()}}
                    <table class="table" id="dataTable">
                        <thead>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($doctor_list as $doctor)
                                <tr>
                                    <td> {{$doctor->name}} {{$doctor->last_name}}  </td>
                                    <td> {{$doctor->specialty ?? "No registrada"}} </td>
                                    <td> <a href="{{url('/agendarDisponibilidad/'.$doctor->id)}}" class="btn btn-primary">Agendar disponibilidad</a>  </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$doctor_list->links()}}
                </div>
            </div>
        </div>

    </div>
</div>


@endsection
