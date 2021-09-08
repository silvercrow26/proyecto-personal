<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //ORM

    // Indicar a la entidad que tabla modificara en la bd
    protected $table = 'image';

    
    // Cuando creo el objeto image puedo llamar al metodo comments, este metodo accede al ORM Comment, 
    // dentro de este ORM tengo dos metodos, users e images.

    // Relacion One To Many, hasMany necesita un parametro principal que vendría a ser la relacion
    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('id','desc'); 
    }
    
    //Relacion One To Many
    public function likes() {
        return $this->hasMany('App\Like'); //Me va a sacar todos los like cuyo id sea igual al que busco.
    }


    // Relacion Many To One
    public function users() {
        return $this->belongsTo('App\User','user_id'); // belongsTo esto me va a sacar el objeto
    }
}
