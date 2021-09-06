<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like; // Cargar modelo Like para crear un objeto en base a ese modelo

class LikeController extends Controller
{
    // Middleware para evitar que se pueda acceder al controlador sin estar autenticado.

    public function __construct() {
        $this->middleware('auth');
    }

    public function like($image_id) {

        // Recoger datos del usuario y la imagen
        $user = \Auth::user();

        // Condicion para comprobar si existe un like y no duplicarlo
        $isset_like = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->count(); // Consultar documentación de laravel

        if ($isset_like == 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            $like->save(); // Guardar like en la base de datos

            //var_dump($like); // ["image_id"]=> string(2) "14" | Castear image_id ya que me la está devolviendo en un string

            return response()->json([
                'like' => $like,
                'message' => 'Has dado like correctamente'
            ]);
        } else {
            return response()->json([
                'message' => 'Ya has dado like a esta foto'
            ]);
        }
    }

    public function dislike($image_id){

        $user = \Auth::user();

        $like = Like::where('user_id', $user->id)
                    ->where('image_id', $image_id)
                    ->first(); // Me permite sacar un único objeto de la bd

        if ($like) { // Si like da true, aplico el delete.

            $like->delete();   // Eliminar like de la base de datos

            return response()->json([
                'like' => $like,
                'message' => 'Has dado dislike correctamente'
            ]);

        } else {
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
        // Agregar ruta dislike
    }

    public function index() {

        $user = \Auth::user();

        $likes = Like::where('user_id', $user->id)->orderBy('id','desc') //Ordenar los like por orden el cual han entrado a la bd
                                ->paginate(5); 

        return view('like.index',[  // Paso un array con las variables que quiero tener disponibles en la vista like.likes
            'likes' => $likes
        ]);
    }
}
