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
                                    $action = "{{$action}}/{{$reference->id}}";
                                }
                            @endphp
                            <form action="" method="POST">
                                @csrf
                                @if ($method == "PUT")
                                    @method('PUT')
                                @endif
                                <input type="text" hidden value="{{$patient->id}}" name="patientId">

                                <label for="">Detalle los examenes que deben realizarse al paciente</label>
                                <textarea class="form-control" name="exams" id="references" cols="30" rows="10">
                                    @if(isset($reference))
                                        {{$reference->exams}}
                                    @else
                                        <ul>
                                            <li>Nombre de examen</li>
                                        </ul>
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

    @include('admin.summernote',["id"=>"references"])

@endsection
