@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Inicio</h1>
                @include('includes.message')
                <!--Foreach para recorrer todas las imagenes y generar un card-->
                @foreach ($images as $image)
                    @include('includes.list-images',['image' => $image])                    
                @endforeach
                @include('includes.paginateImg')
            </div>
        </div>
    </div>
@endsection
