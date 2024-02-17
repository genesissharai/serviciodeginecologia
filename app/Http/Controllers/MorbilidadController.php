<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Morbidity;


class MorbilidadController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function RegistrarMorbi(Request $request)
     {
         echo("=>holaaa");
        
         $morbidity = Morbidity::create([
            'date'=>$request->name,
            'hour'=>$request->name,
            'name'=>$request->name,
            'last_name'=>$request->last_name,
            'ci'=>$request->ci,
            'age'=>$request->fn,
            'pregnancies'=>$request->pregnancies,
            'fvr'=>$request->fvr,
            'ev_x_fur'=>$request->ev_x_fur,
            'first_eco'=>$request->first_eco,
            'eg_x_eco'=>$request->eg_x_eco,
            'ta'=>$request->ta,
            'au'=>$request->au,
            'physical_exam'=>$request->physical_exam,
            'conduct'=>$request->conduct,

        ]);

        echo("=>Registrado");
        


     }


}