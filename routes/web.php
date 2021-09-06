<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Image; // Para utilizar la clase debo hacer el use y acceder al namespace e instanciar el objeto.

Route::get('/', function () {

    // Al haber realizado las relaciones anteriormente puedo obtener la informacion de las tablas en objetos. Sin necesidad de hacer Joins.
    // Select * images innerjoin a la otra tabla etc.
    // Gracias a esto no tengo que hacer una query con el querybuilder para obtener datos de mi BD.

    // $images = Image::all();
    // foreach ($images as $image){
 
    //    echo $image->image_path.'<br/>';
    //    echo $image->description.'<br/>';
    //    echo $image->users->name.' '.$image->users->surname.'<br/>'; // Estoy sacando al usuario que creó imagen 

    //    // Comentarios asociados. Foreach para recorrer los comentarios.
    //    if (count($image->comments) >= 1) { // Mostrando apartado "Comentario" 
    //        echo '<h4>Comentarios</h4>';
    //        foreach($image->comments as $comment) {
    //            echo $comment->users->name.' '.$comment->users->surname.': '; // Accediendo al usuario que hizo el comentario.
    //            echo $comment->content.'<br/>';
    //        }
    //    }
    //    echo 'LIKES: '.count($image->Likes);
    //    echo '<hr/>';
    // }

    return view('welcome');
});

Auth::routes(); // Rutas especiales de laravel

Route::get('/', 'HomeController@index')->name('home');

#### USER ####
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{fileName}','UserController@getImage')->name('user.avatar');
Route::get('/profile/{id}','UserController@profile')->name('profile');
Route::get('/gente','UserController@listaUsuarios')->name('user.all');

#### IMAGE ####
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}','ImageController@getImage')->name('image.file');
Route::get('/image/{id}','ImageController@detail')->name('image.detail');
Route::get('/image/edit/{id}','ImageController@edit')->name('image.edit');
Route::get('/image/delete/{id}','ImageController@delete')->name('image.delete');
Route::post('/image/update','ImageController@update')->name('image.update');

#### COMMENT ####
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}','CommentController@delete')->name('comment.delete');

#### LIKE ####
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');
Route::get('/likes','LikeController@index')->name('likes');