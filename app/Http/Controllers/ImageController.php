<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Image; // Modelo Image
use App\Comment; // 
use App\Like; // 

class ImageController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    // Creando funcion para crear imagenes
    public function create() {
        return view('images.create');
    }

    public function save(Request $request) {

        // Validación
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // Formato del campo

        ]);

        // Recogiendo datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Asignar valor nuevo objeto y settear al usuario que está creando la imagen
        $user = \Auth::user(); // Para acceder a esta funcion debo agregar la barra lateral porque no es un path que tenga añadido como namespace
        $image = new image();
        $image->user_id = $user->id;
        $image->image_path = null;
        $image->description = $description; // Asigno el valor que tiene description.

        // var_dump($user->id);
        // var_dump($image);

        // Crear objeto listo para ser guardado en la base de datos.
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('image')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with([
            'message' => 'La foto ha sido subida correctamente!'
        ]);
    }

    // Función que me permite mostrar la imagen en la página.
    public function getImage($filename) { // Parametro que llega por url
        $file = Storage::disk('image')->get($filename);
        return new Response($file, 200); // Código 200 es de éxito
    }

    public function detail($id) {
        $image = Image::find($id);

        return view('images.detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        $user = \Auth::user(); // Creando objeto del usuario
        $image = Image::find($id); // Buscando la imagen que quiero sacar.

        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if ($user && $image && $image->users->id == $user->id) {

            // Eliminar comentarios
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }

            // Eliminar los likes
            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }

            // Eliminar ficheros de imagenes guardados del storage
            Storage::disk('image')->delete($image->image_path);

            // Eliminar registro imagen
            $image->delete();
            $message = array('message' => 'La imagen se ha borrado correctamente.');
        } else {
            $message = array('message' => 'La imagen no se ha borrado.');
        }

        return redirect()->route('home')->with($message);
    }

    // Creando vista con formulario para editar la imagen

    public function edit($id) {
        $user = \Auth::user();
        $image = Image::find($id);

        // var_dump($image->users->id);
        // var_dump($user->id);

        if($user && $image->users->id == $user->id){
            return view('images.edit',[
                'image' => $image
            ]);

        }else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request) {

        // Validando 
        $validate = $this->validate($request, [
            'description' => 'required'
        ]);

         // Sacando los datos
         $image_id = $request->input('image_id');
         $description = $request->input('description');

        // Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        // Actualizar registro
        $image->update();

        //Redirecciona a image.detail con los cambios actualizados mas un mensaje de éxito.
        return redirect()->route('image.detail',['id' => $image_id])
                         ->with(['message' => 'Imagen actualizada con éxito']);

    }
}
