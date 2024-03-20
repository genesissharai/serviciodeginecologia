<div class="row" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
    <div class="col-12" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
        <div class="row">
            <div class="col-4" style="border-right: 1px solid #999;">Marcar lo encontrado normal después de examinar. Dejar en blanco lo no examinado o interrogado.</div>
            <div class="col-8">Describir lo encontrado mal en la columna izquierda en esta columna usando los numeros de la referencia.</div>
        </div>
    </div>
    <div class="col-12" style="border-top: 1px solid #999; border-bottom: 1px solid #999; padding: 5px 0;">
        <div class="row">
            <div class="col-4" style="border-right: 1px solid #999;">
                {{-- BACKGROUND --}}
                @foreach ($backgroundParametersCategory["subcategories"] as $backgroundParametersSubcategory)
                    <div class="w-100">
                        <p class="text-center "><b>{{$backgroundParametersSubcategory["cardinality"]}}.- {{$backgroundParametersSubcategory["name"]}} </b></p>

                        <ul class="two-columns-list">
                            @foreach ($backgroundParametersSubcategory["parameters"] as $parameter)
                                <li >
                                    <input type="checkbox" name="parameters[]" id="checkbox-{{$parameter["id"]}}" value="{{$parameter["id"]}}" @if(isset($added_parameters) && in_array($parameter["id"], $added_parameters)) checked @endif class="form-check-input">
                                    <label for="checkbox-{{$parameter["id"]}}" class="form-check-label">{{$backgroundParametersSubcategory["cardinality"]}}.{{$parameter["cardinality"]}}- {{$parameter["name"]}}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                {{-- FUNCTIONAL EXAM --}}
                <div class="w-100"><p class="text-center "><b>EXAMEN FUNCIONAL</b></p></div>
                @foreach ($functionalExamParametersCategory["subcategories"] as $functionalExamParametersSubcategory)
                    <div class="w-100">
                        <p class="text-center "><b>{{$functionalExamParametersSubcategory["cardinality"]}}.- {{$functionalExamParametersSubcategory["name"]}} </b></p>
                        <ul class="two-columns-list">
                            @foreach ($functionalExamParametersSubcategory["parameters"] as $parameter)
                                <li >
                                    <input type="checkbox" name="parameters[]" id="checkbox-{{$parameter["id"]}}" value="{{$parameter["id"]}}" @if(isset($added_parameters) && in_array($parameter["id"], $added_parameters)) checked @endif class="form-check-input">
                                    <label  style="white-space: pre-line" for="checkbox-{{$parameter["id"]}}" class="form-check-label">{{$functionalExamParametersSubcategory["cardinality"]}}.{{$parameter["cardinality"]}}- {{$parameter["name"]}}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach


            </div>
            <div class="col-8">
                <textarea name="medical_history_second_part[diagnosis]"  class="form-control h-100" id="" cols="30">@if(isset($medical_history_second_part)) {{$medical_history_second_part['diagnosis']}} @endif</textarea>
            </div>
        </div>
    </div>
</div>
