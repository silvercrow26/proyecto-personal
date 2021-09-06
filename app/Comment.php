<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Me convierte a un mapeo de objetos  los cuales se encuentran anidados y puedo acceder al que necesito.

class Comment extends Model
{
    protected $table = 'comment';

        // Relacion Many To One
        public function users() {
            return $this->belongsTo('App\User','user_id'); // belongsTo esto me va a sacar el objeto cuyo id este relacionado con el user_id
        }

        // Relacion Many To One
        public function images() {
            return $this->belongsTo('App\Image','image_id'); 
        }
}
