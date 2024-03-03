<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\new_tablet;
use App\Models\User;
use Illuminate\Support\Str;


class NewsController extends Controller
{
  
    public function Registernew(Request $request)
    {
    
          
        $CONT = 5686;
          
        if($request->imagen){
            
            $valorAleatorio = uniqid();
            $imagen = $request->imagen;
            $nameImagen = $imagen->hashName();
             $ruta = public_path("imagenes/noticias/");
             $imagen->move($ruta,$nameImagen);
             $slug = Str::of($request->tittle)->slug("-")->limit(255 - mb_strlen($valorAleatorio) - 1, "")->trim("-")->append("-", $valorAleatorio);
             $new = new_tablet::create([

                'title'=>$request->tittle,
                'description'=>$request->description,
                'file_name'=>$nameImagen,
                'slug'=>$slug,
                'status'=>'Activa',
                'order'=>$CONT,
                'type'=>'Noticia',
                'author_id'=>\Auth::id(),
    
            ]);

            return view('/noticia.registrar',['title' => 'Noticia'],);
            }
      
    }
    public function consultnews(Request $request)
    {

        $new = new_tablet::orderBy('id','desc')->paginate();

        $contador = 1;
        
        return view('/noticia.consultar',['title' => 'Noticia'],compact('new', 'contador'));
      
    }
    public function editarNoticia($id)
    {

        $new = new_tablet::find($id);
        return view('/noticia.edit',['title' => 'Noticia'],compact('new'));
      
    }
    public function update($id,Request $request)
    {

        if($request->imagen){
            $new = new_tablet::find($id);
            $valorAleatorio = uniqid();
            $imagen = $request->imagen;
            $nameImagen = $imagen->hashName();
             $ruta = public_path("imagenes/noticias/");
             $imagen->move($ruta,$nameImagen);
             $slug = Str::of($request->tittle)->slug("-")->limit(255 - mb_strlen($valorAleatorio) - 1, "")->trim("-")->append("-", $valorAleatorio);
             $cont= 1;

             $new->title=$request->tittle;
             $new->description=$request->description;
             $new->file_name=$nameImagen;
             $new->slug=$slug;
             $new->status='Activa';
             $new->order=$cont;
             $new->type='Noticia';
             $new->author_id=\Auth::id();
             $new->save();


              $new = new_tablet::orderBy('id','desc')->paginate();
              return view('/noticia.consultar',['title' => 'Noticia'],compact('new', 'cont'));

       }
    }
    public function destroy($id)
    {

        $new = new_tablet::find($id);
        $new->delete();
        $cont= 1;
        $new = new_tablet::orderBy('id','desc')->paginate();
        return view('/noticia.consultar',['title' => 'Noticia'],compact('new'));
      
    }

    


}
