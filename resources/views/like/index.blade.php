@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Mis imágenes favoritas</h1>

                @foreach ($likes as $like)
                    @include('includes.list-images',['image' => $like->images])
                @endforeach
                <div class="clearfix"></div>
                {{$likes->render()}}
            </div>
        </div>
    </div>
@endsection
