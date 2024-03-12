@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-title">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>
                                Paciente: {{$patient->fullName()}}
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @php
                                $action = "{{$action}}/{{$patient->id}}";
                                if($method == "PUT"){
                                    $action = "{{$action}}/{{$informeMedico->id}}";
                                }
                            @endphp
                            <form action="" method="POST">
                                @csrf
                                @if ($method == "PUT")
                                    @method('PUT')
                                @endif
                                <input type="text" hidden value="{{$patient->id}}" name="patientId">
                                <label for="">Titulo</label>
                                <input type="text" @if(isset($informeMedico)) value="{{$informeMedico->title}}" @endif name="title" class="form-control">
                                <br>
                                <label for="">Detalles del informe</label>
                                <textarea class="form-control" name="report" id="informeMedico" cols="30" rows="10">
                                    @if(isset($informeMedico))
                                        {{$informeMedico->report}}
                                    @else
                                        <b>Información del paciente:</b><br><b>Síntomas actuales:</b><br><b>Diagnóstico:</b><br><b>Tratamiento:</b><br><b>Pronóstico:</b><br>
                                    @endif
                                </textarea>
                                <br>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.summernote',["id"=>"informeMedico"])

@endsection
