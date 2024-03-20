<div class="row" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
    <div class="col-12 mb-1">
        <div class="row">
            <div class="col-1 p-0 text-right">
                <label style="font-size: 0.75em;" for="" class="form-label mr-1">TEMPERATURA: C° &nbsp;</label>
            </div>
            <div class="col-1 p-0 text-right">
                <input type="text" @if(isset($medical_history_third_part)) value="{{$medical_history_third_part['temperature_celcius']}}" @endif name="medical_history_third_part[temperature_celcius]" class="form-control">
            </div>
            <div class="col-1 p-0 text-right">
                <label style="font-size: 0.75em;" for="" class="form-label mr-1">PULSO: &nbsp;</label>
            </div>
            <div class="col-1 p-0 text-right">
                <input type="text" @if(isset($medical_history_third_part)) value="{{$medical_history_third_part['pulse']}}" @endif name="medical_history_third_part[pulse]" class="form-control">
            </div>
            <div class="col-1 p-0 text-right">
                <label style="font-size: 0.75em;" for="" class="form-label mr-1">P.P.M. RESPIRACION: &nbsp;</label>
            </div>
            <div class="col-1 p-0 text-right">
                <input type="text" @if(isset($medical_history_third_part)) value="{{$medical_history_third_part['bpm_breathing']}}" @endif name="medical_history_third_part[bpm_breathing]" class="form-control">
            </div>
            <div class="col-1 p-0 text-right">
                <label style="font-size: 0.75em;" for="" class="form-label mr-1">R.P.M. TENSION ARTERIAL: MX &nbsp;</label>
            </div>
            <div class="col-1 p-0 text-right">
                <input type="text" @if(isset($medical_history_third_part)) value="{{$medical_history_third_part['max_blood_pressure']}}" @endif name="medical_history_third_part[max_blood_pressure]" class="form-control">
            </div>
            <div class="col-1 p-0 text-right">
                <label style="font-size: 0.75em;" for="" class="form-label mr-1">R.P.M. TENSION ARTERIAL: MN: &nbsp;</label>
            </div>
            <div class="col-1 p-0 text-right">
                <input type="text" @if(isset($medical_history_third_part)) value="{{$medical_history_third_part['min_blood_pressure']}}" @endif name="medical_history_third_part[min_blood_pressure]" class="form-control">
            </div>
            <div class="col-1 p-0 text-right">
                <label style="font-size: 0.75em;" for="" class="form-label mr-1">PESO: KGS &nbsp;</label>
            </div>
            <div class="col-1 p-0 text-right">
                <input type="text" @if(isset($medical_history_third_part)) value="{{$medical_history_third_part['weight_kgs']}}" @endif name="medical_history_third_part[weight_kgs]" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-12" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
        <div class="row">
            <div class="col-4" style="border-right: 1px solid #999;">Marcar lo encontrado normal después de examinar. Dejar en blanco lo no examinado o interrogado.</div>
            <div class="col-8">Describir lo encontrado mal en la columna izquierda en esta columna usando los numeros de la referencia.</div>
        </div>
    </div>
    <div class="col-12" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
        <div class="row">
            <div class="col-4" style="border-right: 1px solid #999;">
                {{-- FUNCTIONAL EXAM --}}
                <div class="w-100"><p class="text-center "><b>{{$physicalExamParametersCategory["name"]}}</b></p></div>
                @foreach ($physicalExamParametersCategory["subcategories"] as $physicalExamParametersSubcategory)
                    <div class="w-100">
                        <p class="text-center "><b>{{$physicalExamParametersSubcategory["cardinality"]}}.- {{$physicalExamParametersSubcategory["name"]}} </b></p>
                        <ul class="two-columns-list">
                            @foreach ($physicalExamParametersSubcategory["parameters"] as $parameter)
                                <li >
                                    <input type="checkbox" name="parameters[]" id="checkbox-{{$parameter["id"]}}" value="{{$parameter["id"]}}" @if(isset($added_parameters) && in_array($parameter["id"], $added_parameters)) checked @endif class="form-check-input">
                                    <label  style="white-space: pre-line" for="checkbox-{{$parameter["id"]}}" class="form-check-label">{{$physicalExamParametersSubcategory["cardinality"]}}.{{$parameter["cardinality"]}}- {{$parameter["name"]}}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach


            </div>
            <div class="col-8">
                <textarea name="medical_history_third_part[diagnosis]"  class="form-control h-100" id="" cols="30">@if(isset($medical_history_third_part)) {{$medical_history_third_part['diagnosis']}} @endif</textarea>
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <label for="" class="form-label">Diagnóstico del Servicio:</label>
        <textarea name="medical_history_third_part[service_diagnosis]"  class="form-control" id="" cols="30" rows="6">@if(isset($medical_history_third_part)) {{$medical_history_third_part['service_diagnosis']}} @endif </textarea>
    </div>
</div>
