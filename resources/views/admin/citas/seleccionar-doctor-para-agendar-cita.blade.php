@extends('admin.layout')
@section('content')

<div class="row">
    <div class="card shadow mb-4 col-12">
        <div class="card-body">
            <form action="/agendarCita" method="GET">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name" @if(isset($searchTerms["name"])) value="{{$searchTerms["name"]}}"  @endif>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="">Correo</label>
                        <input type="text" class="form-control" name="email" @if(isset($searchTerms["email"])) value="{{$searchTerms["email"]}}"  @endif>
                    </div>
                </div>
                <button class="btn btn-info mt-3">Buscar</button>
            </form>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div class="table-responsive">
                    {{$doctor_list->links()}}
                    <table class="table" id="dataTable">
                        <thead>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Correo</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($doctor_list as $doctor)
                                <tr>
                                    <td> {{$doctor->name}} {{$doctor->last_name}}  </td>
                                    <td> {{$doctor->doctorHierarchy->specialty ?? "No registrada"}} </td>
                                    <td> {{$doctor->email}}  </td>
                                    <td> <a href="{{url('/agendarCita/'.$doctor->id)}}" class="btn btn-primary">Agendar disponibilidad</a>  </td>
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
