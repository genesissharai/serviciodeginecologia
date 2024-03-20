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
                            <div class="border-block">
                                <form action="{{$action}}" id="formMedicalHistory" method="post">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="patient_id" id="" hidden value="{{$patient->id}}">

                                    <nav>
                                        <div class="nav nav-tabs border-bottom-0 mb-1 p-0" id="nav-tab" role="tablist">
                                          <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Parte I</button>
                                          <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Parte II</button>
                                          <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Parte III</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content container-fluid p-0" id="medicalHistory">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                            @include('admin.historia-clinica.parte-1-historia-clinica')

                                        </div>
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                                            @include('admin.historia-clinica.parte-2-historia-clinica')

                                        </div>
                                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                                            @include('admin.historia-clinica.parte-3-historia-clinica')

                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2" type="submit">Guardar</button>
                                </form>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        input, textarea, select, option{
            border-color: #999 !important;
        }
        .two-columns-list{
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
            list-style-type: none;
        }
    </style>

    {{-- @include('admin.summernote',["id"=>"informeMedico"]) --}}

@endsection
