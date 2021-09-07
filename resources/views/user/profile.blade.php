@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-user">

                    @if ($user->image)
                        <div class="rounded-circle container-avatar">
                            <img class="card-img-top avatar"
                                src="{{ route('user.avatar', ['fileName' => $user->image]) }}"
                                alt="Card image cap">
                        </div>
                    @endif
                    <div class="user-info">
                        <h1>{{ '@' . $user->nick }}</h1>
                        <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                        <p>{{ 'Se unió: ' . \FormatTime::LongTimeFilter($user->created_at) }}</p>
                    </div>
                </div>

                <div class="clearfix"></div>
                
                @foreach ($user->images as $image)
                    @include('includes.list-images',['image' => $image])
                @endforeach
                
            </div>      
        </div>
    </div>
@endsection
