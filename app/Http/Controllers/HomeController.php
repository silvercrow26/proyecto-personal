<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $images = Image::orderBy('id','desc')->paginate(5); // Siempre que use un orderby o paginate, o lo que sea debo poner el ->get() para sacar los datos.

        return view('home', [
            'images' => $images,
        ]);
    }
}
