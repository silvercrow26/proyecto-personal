@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('includes.message')
                <!--Foreach para recorrer todas las imagenes y generar un card-->
                <div class="card pub_image pub_image_detail">
                    <!--Imagen, metodo users del modelo imagen y su nombre-->
                    <div class="card-header">
                        @if ($image->users->image)
                            @include('includes.image')
                        @endif

                        <div class="data-user">
                            <a href="{{ route('image.detail', ['id' => $image->id]) }}">
                                {{ $image->users->name . ' ' . $image->users->surname }}
                                <span class="nickname">{{ ' | @' . $image->users->nick }} </span>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!--Metodo para buscar la imagen en el Storage dentro de ImageController ___class_+?8___-->
                        <img class="" src="{{ route('image.file', ['filename' => $image->image_path]) }}">
                        <!--- indice que le paso por la url--->
                    </div>

                    <div class="likes">
                        <!-- Comprobar si el usuario ha dado like -->
                        <?php $user_like = false; ?>

                        @foreach ($image->likes as $like)
                            @if ($like->users->id == Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach

                        @if ($user_like)
                            <img src="{{ asset('icons/hearts-red.png') }}" data-id="{{ $image->id }}"
                                class="btn-like" />
                        @else
                            <img src="{{ asset('icons/hearts-gray.png') }}" data-id="{{ $image->id }}"
                                class="btn-dislike" />
                        @endif
                        <span class="nickname">{{ count($image->likes) }}</span>
                    </div>

                    <div class="description">
                        <span class="nickname">{{ '@' . $image->users->nick }} </span>
                        <span class="nickname">{{ ' | ' . \FormatTime::LongTimeFilter($image->created_at) }}</span>
                        <p>{{ $image->description }}</p>
                    </div>


                    @if (Auth::user() && Auth::user()->id == $image->user_id)
                        <div class="action">

                            <a class="btn btn-sm btn-primary" href="{{route('image.edit', ['id' => $image->id])}}">Modificar</a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#exampleModal">Borrar</button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">¿Desea borrar la imagen?
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Si borra esta imagen no podrá recuperarla.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <a href="{{ route('image.delete', ['id' => $image->id]) }}"
                                                class="btn btn-sm btn-danger">Borrar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="clearfix">
                        <div class="comments">
                            <h2>Comentarios ({{ count($image->comments) }})</h2>
                            <hr />

                            <form method="POST" action="{{ route('comment.save') }}">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}" />
                                <p>
                                    <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                        name="content" required></textarea>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </p>
                                <button type="submit" class="btn btn-success">Enviar

                                </button>
                            </form>
                            <hr />
                            @foreach ($image->comments as $comment)
                                <div class="comment">

                                    <span class="nickname">{{ '@' . $comment->users->nick }} </span>
                                    <span
                                        class="nickname">{{ ' | ' . \FormatTime::LongTimeFilter($comment->created_at) }}</span>
                                    <p>{{ $comment->content }}
                                        @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->images->user_id == Auth::user()->id))
                                            <br><a href="{{ route('comment.delete', ['id' => $comment->id]) }}">Eliminar
                                                comentario</a>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
