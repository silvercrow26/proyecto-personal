@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Editar imagen</h1>
                <div class="card">
                    <div class="card-header">Editar imagen</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('image.update')}}" enctype="multipart/form-data">
                            @csrf

                            
                            <input type="hidden" name="image_id" value="{{$image->id}}" />

                            <div class="form-group row">
                                <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                                <div class="col-md-7">

                                    <img class="" src="{{ route('image.file', ['filename' => $image->image_path]) }}">
                                    {{-- <input id="image_path" type="file" name="image_path" class="form-control form-campo {{ $errors->has('content')? 'is-invalid' : ''}}"
                                        required /> --}}

                                    {{-- Comprobando si existe algun error en el campo image_path --}}
                                    {{-- @if ($errors->has('image_path'))
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $errors->first('image_path') }}</strong>
                                        </span>
                                    @endif --}}


                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-3 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-7">
                                    <!--Nombre de la variable que me llega al controlador-->
                                    <textarea id="description" name="description"
                                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                        required>{{ $image->description }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                            <!--Muestras el primero que llega en el array-->
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-3">
                                    <!--Nombre de la variable que me llega al controlador-->
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
