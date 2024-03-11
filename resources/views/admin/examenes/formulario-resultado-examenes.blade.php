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
                            <p>Examen mandado:</p>
                            <p class="p-2">
                                {!!$reference->exams!!}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            @php
                                $action = "{{$action}}/{{$reference->id}}";
                                if($method == "PUT"){
                                    $action = "{{$action}}/{{$examResult->id}}";
                                }
                            @endphp
                            <form action="" method="POST">
                                @csrf
                                @if ($method == "PUT")
                                    @method('PUT')
                                @endif
                                <input type="text" hidden value="{{$patient->id}}" name="patientId">

                                <label for="">Resultados</label>
                                <textarea class="form-control" name="result" id="examResult" cols="30" rows="10">
                                    @if(isset($examResult))
                                        {{$examResult->result}}
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
    @include('admin.summernote',["id"=>"examResult"])


@endsection
