<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\new_tablet;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class EventosController extends Controller
{
    //
    public function iniciar(Request $request)
    {
        $noticia = DB::table('news_table')->orderBy('id','desc')->where('type', '=','Evento')->paginate(10);
        $contador = 1;
        

        return view('/evento.registrar',['title' => 'Eventos'], compact('noticia', 'contador'));

    }


    public function Registereventos(Request $request)
    {

          
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
                'author'=>$request->autor,
                'type'=>'Evento',
                'author_id'=>\Auth::id(),
    
            ]);

            $noticia = DB::table('news_table')->orderBy('id','desc')->where('type', '=','Evento')->get();
            $contador = 1;

            /*foreach ($noticia as $user) {
                echo $user->title;
            }*/
           return view('/evento.registrar',['title' => 'Eventos'], compact('noticia', 'contador'));
            }
      
    }
    public function consulevents($id)
    {

        
        $new = new_tablet::find($id);
        return view('/evento.consultar',['title' => 'Eventos'],compact('new'));

    }
    public function editevents($id)
    {

        
        $new = new_tablet::find($id);
        return view('/evento.update',['title' => 'Eventos'],compact('new'));

    }
    public function updateeventos($id, Request $request)
    {

        
        $new = new_tablet::find($id);
        
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
             $new->author=$request->autor;
             $new->type='Evento';
             $new->author_id=\Auth::id();
             $new->save();


             // $new = new_tablet::orderBy('id','desc')->paginate();
             $noticia = DB::table('news_table')->orderBy('id','desc')->where('type', '=','Evento')->paginate(10);
             $contador = 1;
              return view('/evento.registrar',['title' => 'Eventos'], compact('noticia', 'contador'));

       }
   }

       public function destroy($id){
   
           
           $new = new_tablet::find($id);
           $new->delete();
           $noticia = DB::table('news_table')->orderBy('id','desc')->where('type', '=','Evento')->paginate(10);
            $contador = 1;
            return view('/evento.registrar',['title' => 'Eventos'], compact('noticia', 'contador'));

   
       }

    

}
