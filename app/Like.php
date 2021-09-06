<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $table = 'like';

    // Relacion Many To One
    public function users() {
        return $this->belongsTo('App\User','user_id'); // belongsTo esto me va a sacar el objeto cuyo id este relacionado con el user_id
    }

    // Relacion Many To One
    public function images() {
        return $this->belongsTo('App\Image','image_id'); 
    }
    
}
