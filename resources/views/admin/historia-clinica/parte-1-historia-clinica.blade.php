<div class="row" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
        <div class="col-12">
            <div class="row">
                <div class="col-12" style="padding: 0.5em; border-bottom: 1px solid #999;"><p class="m-0">DATOS DEL PACIENTE:</p></div>
                <div class="col-4" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">APELLIDOS Y NOMBRES:</label>
                    <input class="form-control" @if(isset($patient_data)) value="{{$patient_data['fullname']}}" @endif name="patient_data[fullname]" type="text">
                </div>
                <div class="col-3" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">CEDULA DE IDENTIDAD Nº:</label>
                    <input class="form-control" @if(isset($patient_data)) value="{{$patient_data['ci']}}" @endif name="patient_data[ci]" type="text">
                </div>
                <div class="col-2" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">SEXO:</label>
                    <select name="patient_data[sex]" id="" class="form-control">
                        <option value="FEMENINO" selected> FEMENINO</option>
                    </select>
                </div>
                <div class="col-1" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">EDAD:</label>
                    <input class="form-control" @if(isset($patient_data)) value="{{$patient_data['age']}}" @endif name="patient_data[age]" id="age" type="text" readonly>
                </div>
                <div class="col-2" style="padding: 0.5em; border-bottom: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">EDO. CIVIL:</label>
                    <input class="form-control" @if(isset($patient_data)) value="{{$patient_data['civil_status']}}" @endif name="patient_data[civil_status]" type="text">
                </div>

                <div class="col-3" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">LUGAR DE NACIMIENTO:</label>
                    <input class="form-control" @if(isset($patient_data)) value="{{$patient_data['place_of_birth']}}" @endif name="patient_data[place_of_birth]" type="text">
                </div>
                <div class="col-2" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">FECHA DE NACIMIENTO:</label>
                    <input class="form-control" id="birthdate" @if(isset($patient_data)) value="{{$patient_data['birthdate']}}" @endif name="patient_data[birthdate]" type="date">
                </div>
                <div class="col-2" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">NACIONALIDAD:</label>
                    <select name="patient_data[nationality]" id="" class="form-control">
                        <option value="VENEZOLANO" @if(isset($patient_data) && $patient_data['nationality'] != "EXTRANJERO") selected @endif> VENEZOLANO</option>
                        <option value="EXTRANJERO" @if(isset($patient_data) && $patient_data['nationality'] == "EXTRANJERO") selected @endif > EXTRANJERO</option>
                    </select>
                </div>
                <div class="col-5" style="padding: 0.5em; border-bottom: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">OCUPACION:</label>
                    <input class="form-control" @if(isset($patient_data)) value="{{$patient_data['occupation']}}" @endif name="patient_data[occupation]" type="text">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">

                <div class="col-12" style="padding: 0.5em; border-bottom: 1px solid #999;"><p class="m-0">EN CASO DE EMERGENCIA AVISAR A:</p></div>

                <div class="col-4" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">APELLIDO Y NOMBRE:</label>
                    <input type="text" @if(isset($emergency_contact)) value="{{$emergency_contact['fullname']}}" @endif name="emergency_contact[fullname]" class="form-control">
                </div>
                <div class="col-3" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">PARENTESCO:</label>
                    <input type="text" @if(isset($emergency_contact)) value="{{$emergency_contact['relationship']}}" @endif name="emergency_contact[relationship]" class="form-control">
                </div>
                <div class="col-5" style="padding: 0.5em; border-bottom: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">DIRECCION:</label>
                    <input type="text" @if(isset($emergency_contact)) value="{{$emergency_contact['address']}}" @endif name="emergency_contact[address]" class="form-control">
                </div>


		        <div class="col-3" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;"></div>
		        <div class="col-3" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">FECHA DE INGRESO:</label>
                    <input type="date" @if(isset($medical_history_first_part)) value="{{$medical_history_first_part['date_of_admission']}}" @endif name="medical_history_first_part[date_of_admission]" class="form-control">
                </div>
                <div class="col-2" style="padding: 0.5em; border-bottom: 1px solid #999; border-right: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">HORA:</label>
                    <input type="time" @if(isset($medical_history_first_part)) value="{{$medical_history_first_part['hour_of_admission']}}" @endif name="medical_history_first_part[hour_of_admission]" class="form-control">
                </div>
                <div class="col-4" style="padding: 0.5em; border-bottom: 1px solid #999;">
                    <label style="font-size: 0.825em;" for="" class="form-label">FECHA ADMISION ANTERIOR:</label>
                    <input type="date" @if(isset($medical_history_first_part)) value="{{$medical_history_first_part['previous_date_of_admission']}}" @endif name="medical_history_first_part[previous_date_of_admission]" class="form-control">
                </div>

            </div>
        </div>
        <div class="col-12" style="border-top: 1px solid #999; padding: 0.5em; margin-top: 5px;">
            <label for="" class="form-label">MOTIVO(S) DE INGRESO:</label>
            <textarea name="medical_history_first_part[reason_for_admission]"  class="form-control" id="" cols="30" rows="3">@if(isset($medical_history_first_part)) {{$medical_history_first_part['reason_for_admission']}} @endif</textarea>
        </div>
        <div class="col-12" style="padding: 0.5em; margin-top: 5px;">
            <label for="" class="form-label">ENFERMEDAD ACTUAL: <small> (HACER RELATO CONCISO Y COMPLETO DE LAS DOLENCIAS, INDICANDO FECHA DE COMIENZO, DURACION Y TRATAMIENTO DE CADA UNA DE ELLAS)</small>:</label>
            <textarea name="medical_history_first_part[current_illness]"  class="form-control" id="" cols="30" rows="11">@if(isset($medical_history_first_part)) {{$medical_history_first_part['current_illness']}}@endif</textarea>
        </div>
        <div class="col-12" style="padding: 0.5em; margin-top: 0.5em; border-bottom: 1px solid #999; margin-bottom: 0.25em;">
            <div class="row">
                <div class="col-9">
                    <label for="" class="form-label">DIAGNOSTICO PROVISIONAL:</label>
                    <textarea name="medical_history_first_part[provisional_diagnosis]"  class="form-control" id="" cols="30" rows="4">@if(isset($medical_history_first_part)) {{$medical_history_first_part['provisional_diagnosis']}} @endif</textarea>
                </div>
                <div class="col-3">
                    <label for="" class="form-label">FIRMA DEL MEDICO:</label>
                </div>
            </div>
        </div>
        <div class="col-12 p-0 pt-2" style="border-top: 1px solid #999;">
            <div class="row">

                <div class="col-8">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-2"><label for="" class="form-label">EGRESO POR:</label></div>
                            <div class="col-5">
                                <input type="radio" name="medical_history_first_part[egress_reason]" value="CURACION" @if(isset($medical_history_first_part) && $medical_history_first_part["egress_reason"] == "CURACION") checked @endif class="form-check-input">
                                <label for="" class="form-check-label">CURACION</label>
                            </div>
                            <div class="col-5">
                                <input type="radio" name="medical_history_first_part[egress_reason]" value="MEJORIA" @if(isset($medical_history_first_part) && $medical_history_first_part["egress_reason"] == "MEJORIA") checked @endif class="form-check-input">
                                <label for="" class="form-check-label"> MEJORIA</label>
                            </div>
                            <div class="col-2"><label for="" class="form-label"></label></div>
                            <div class="col-5">
                                <input type="radio" name="medical_history_first_part[egress_reason]" value="MUERTE" @if(isset($medical_history_first_part) && $medical_history_first_part["egress_reason"] == "MUERTE") checked @endif class="form-check-input">
                                <label for="" class="form-check-label">MUERTE</label>
                            </div>
                            <div class="col-5">
                                <input type="radio" name="medical_history_first_part[egress_reason]" value="AUTOPSIA PEDIDA" @if(isset($medical_history_first_part) && $medical_history_first_part["egress_reason"] == "AUTOPSIA PEDIDA") checked @endif class="form-check-input">
                                <label for="" class="form-check-label">AUTOPSIA PEDIDA</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <input type="radio" name="medical_history_first_part[egress_reason]" value="OTRAS CAUSAS:" @if(isset($medical_history_first_part) && str_starts_with($medical_history_first_part["egress_reason"], "OTRAS CAUSAS:")) checked @endif id="other_egress_reason">
                    <label for="" class="form-label">OTRAS CAUSAS:</label>
                    <div>
                        <input type="text" name="medical_history_first_part[custom_egress_reason]" id="custom_egress_reason" class='form-control'  @if(isset($medical_history_first_part) && str_starts_with($medical_history_first_part["egress_reason"], "OTRAS CAUSAS:")) value="{{trim(explode('OTRAS CAUSAS:', $medical_history_first_part["egress_reason"])[1])}}" @endif >
                        <small>(SI CONTRA OPINION MEDICA, HACERLE FIRMAR EL DORSO)</small>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12" style="padding: 0.5em; margin-top: 5px;">
            <label for="" class="form-label">DIAGNOSTICO CLINICO FINAL:</label>
            <textarea name="medical_history_first_part[final_diagnosis]" class="form-control" id="" cols="30" rows="3">@if(isset($medical_history_first_part)) {{$medical_history_first_part['final_diagnosis']}} @endif</textarea>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <div class="col-1" style="border-bottom: 1px solid #999;"></div>
                <div class="col-2 text-right" style="border-bottom: 1px solid #999;">
                    <label for="" class="col-form-label">FECHA DE EGRESO:</label>
                </div>
                <div class="col-2" style="border-bottom: 1px solid #999;">
                    <input @if(isset($medical_history_first_part)) value="{{$medical_history_first_part['egress_date']}}" @endif name="medical_history_first_part[egress_date]" type="date" class="form-control">
                </div>
                <div class="col-1 text-center" style="border-bottom: 1px solid #999;">
                    <label for="" class="col-form-label">HORA:</label>
                </div>
                <div class="col-2" style="border-bottom: 1px solid #999;">
                    <input @if(isset($medical_history_first_part)) value="{{$medical_history_first_part['egress_hour']}}" @endif name="medical_history_first_part[egress_hour]" type="time" class="form-control">
                </div>
                <div class="col-1"  style="padding: 0.5em; border-right: 1px solid #999; border-bottom: 1px solid #999;"></div>
                <div class="col-3" style="height: 100px; border-bottom: 1px solid #999;">
                    <label for="" class="form-label">FIRMA DEL (LA) JEFE(A) DE SERVICIO:</label>
                </div>
            </div>
        </div>
        <div class="col-12" style="padding: 0.5em; border-bottom: 1px solid #999;">
            <label for="" class="form-label">DIAGNOSTICO ANATOMO – PATOLOGICO:</label>
            <textarea name="medical_history_first_part[anatopathological_diagnosis]" class="form-control" id="" cols="30" rows="3">@if(isset($medical_history_first_part)) {{$medical_history_first_part['anatopathological_diagnosis']}} @endif</textarea>
        </div>

</div>
