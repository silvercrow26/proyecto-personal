@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @foreach ($listaUsuarios as $listaUsuario)
                    <div class="profile-user">

                        @if ($listaUsuario->images)
                            <div class="rounded-circle container-avatar">
                                <img class="card-img-top avatar"
                                    src="{{ route('user.avatar', ['fileName' => $listaUsuario->image]) }}"
                                    alt="Card image cap">
                            </div>
                        @endif

                        <div class="user-info">
                            <h1>{{ '@' . $listaUsuario->nick }}</h1>
                            <h2>{{ $listaUsuario->name . ' ' . $listaUsuario->surname }}</h2>
                            <p>{{ 'Se unió: ' . \FormatTime::LongTimeFilter($listaUsuario->created_at) }}</p>
                            <a href="{{route('profile',['id' => $listaUsuario->id])}}" class="btn btn-success">Ver perfil</a>
                        </div>

                    </div>
                    <hr/>
                @endforeach

                <div class="clearfix"></div>
                {{ $listaUsuarios->render() }}
            </div>
        </div>
    </div>
@endsection
