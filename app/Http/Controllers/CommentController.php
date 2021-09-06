<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        // Validacion
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        // Recogiendo datos del form
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Asigno los valores a mi nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        // Guardando en la base de datos
        $comment->save();

        //Redirección
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with([
                            'message' => 'Has publicado tu mentario correctamente!'
                         ]);
    }

    public function delete($id) {
        // Conseguir datos del usuario identificado
        $user = \Auth::user(); // Datos del usuario que está logeado en las sesión

        // Conseguir objeto del comentario
        $comment = Comment::find($id); // Con el metodo find si yo lo entrego una id de un registro me devuelve un objeto de ese registro.

        // Comprobar dueño del comentario o de la publicación

        // Cuando el id del usuario que ha creado el comentario sea igual al del usuario identificado o 
        // cuando el id del usuario que ha creado la imagen sea igual a la del usuario identificado

        if( $user && ($comment->user_id == $user->id || (($comment->images) && $comment->images->user_id == $user->id)) ) {
            
            $comment->delete();
            
            return redirect()->route('image.detail', ['id' => $comment->image_id])
                         ->with([
                            'message' => 'El comentario se ha eliminado correctamente!'
                         ]);
                         
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                         ->with([
                            'message' => 'El comentario no se ha eliminado!'
                        ]);
        }
    }
}
