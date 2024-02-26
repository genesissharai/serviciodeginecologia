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
        
        return redirect()->intended('/registrarmorbilidad');

     }

     public function consultarMorbi(Request $request)
     {
        $morbidities = Morbidity::orderBy('id','desc')->paginate();

        //Return $morbidities;

        $contador = 1;
        
        return view('/morbilidad.consultar',['title' => 'Morbilidad'],compact('morbidities', 'contador'));

     }

     public function editarMorbi($id)
     {

      $morbidities = Morbidity::find($id);

      return view('/morbilidad.edit',['title' => 'Morbilidad'],compact('morbidities'));
     }

     public function update($id, Request $request)
     {
      $morbidities = Morbidity::find($id);
      $morbidities->name = $request->name;
      $morbidities->last_name = $request->last_name;
      $morbidities->ci = $request->ci;
      $morbidities->age=$request->fn;
      $morbidities->pregnancies=$request->pregnancies;
      $morbidities->fvr=$request->fvr;
      $morbidities->ev_x_fur=$request->ev_x_fur;
      $morbidities->first_eco=$request->first_eco;
      $morbidities->eg_x_eco=$request->eg_x_eco;
      $morbidities->ta=$request->ta;
      $morbidities->au=$request->au;
      $morbidities->physical_exam=$request->physical_exam;
      $morbidities->conduct=$request->conduct;
      $morbidities->save();
     }

     public function destroy($id)
     {
      $contador = 1;
      $morbidities = Morbidity::find($id);
      
      $morbidities->delete();
      

      $morbidities = Morbidity::orderBy('id','desc')->paginate();
      
      return view('/morbilidad.consultar',['title' => 'Morbilidad'],compact('morbidities','contador'));
     }

}