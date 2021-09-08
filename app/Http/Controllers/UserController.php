<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Like;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage; // STORAGE!!!
use Illuminate\support\Facades\File;
use App\User;

class UserController extends Controller
{
    public function __construct() { // Controladores controlados por autenticación
        $this->middleware('auth');
    }

    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {

        // Conseguir al usuario identificado
        $user = \Auth::user();
        $id = $user->id; // Acceder al id;

        // Validación del formulario
        $validate = $this->validate($request, [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:200',
            'nick' => 'required|string|max:100|unique:user,nick,' . $id,
            'email' => 'required|string|email|max:255|unique:user,email,' . $id // Excepcion en caso de que el email.id coincida con el email
        ]);

        // Recoger datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        // Subir la imagen
        $image_path = $request->file('image_path');
        if ($image_path) { // Si me da true, debo utilizar el storage y el disco users

            // Poniendo nombre unico a la imagen. Nombre del fichero original de esta forma el nombre será exclusivo.
            $image_path_name = time() . $image_path->getClientOriginalName();

            // Seleccionando el disco user, metodo put para subir la imagen en el storage(storage/app/user), primer parámetro es el nombre y segundo va la imagen. Guardarla.
            storage::disk('user')->put($image_path_name, File::get($image_path));

            $user->image = $image_path_name; // Setear el nombre de la imagen con un nombre único en el objeto.
        }

        // Ejecutar consultas y cambios en la base de datos

        $user->update();

        return redirect()->route('config')
            ->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($fileName) {
        $file = Storage::disk('user')->get($fileName);
        return new Response($file, 200); // Me lo devuelve en su formato para imprimirlo por pantalla
    }

    // Funcion profile, con variable $id del usuario que recibirá por url
    public function profile($id) {
        $user = User::find($id); 

        return view('user.profile',[ 
            'user' => $user // Devuelvo mi objeto usuario dentro la variable user
        ]);
    }

    // Funcion listaUsuarios
    public function listaUsuarios() {
        $listaUsuarios = User::orderBy('id','desc')->paginate(5); // Metodo orderBy para listar a los usuarios más nuevos primero.

        return view('user.listaUsuarios',[
            'listaUsuarios' => $listaUsuarios
        ]);
    }
}
