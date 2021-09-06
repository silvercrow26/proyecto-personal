@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="card ">
            <div class="card-header">
                <h5 class="text-center">Configuración de mi cuenta</h5>
            </div>
            <div class="card text-white bg-secondary servicios">

                <div class="card card-fondo" style="100%;">
                    <div class="img-thumbnail">
                        @include('includes.avatar')
                    </div>

                    <div class="card-body">
                        <p class="card-text">{{ auth::user()->name }} "{{ auth::user()->nick }}"
                            {{ Auth::user()->surname }}<br />
                            {{ Auth::user()->email }}</p>

                    </div>
                </div>

                <div class="card-body">
                    <!--Form para subir archivos-->
                    <form method="POST" onkeypress="return event.keyCode != 13;" enctype="multipart/form-data" action="{{ route('user.update') }}" >
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Nombre</label>
                                <input id="name" placeholder="Nombre" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ auth::user()->name }}" required autocomplete="name">
                            </div>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="form-group col-md-6">
                                <label for="nick">Nick</label>
                                <input id="nick" placeholder="Nick" type="text"
                                    class="form-control @error('nick') is-invalid @enderror" name="nick"
                                    value="{{ auth::user()->nick }}" required autocomplete="nick" >
                                @error('nick')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="surname">Apellido</label>
                            <input id="surname" placeholder="Apellido" type="text"
                                class="form-control @error('surname') is-invalid @enderror" name="surname"
                                value="{{ Auth::user()->surname }}" required autocomplete="surname">
                        </div>
                        @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ Auth::user()->email }}" required autocomplete="email"
                                autofplaceholder="example@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">

                            <input id="image_path" type="file" class="control @error('image_path') is-invalid @enderror"
                                name="image_path">
                            @error('image_path')
                                <span id="alert" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="form-row">
              <div class="form-group col-md-6">
                <label for="password">Contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="********">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                   @enderror
              </div>
              <div class="form-group col-md-6">
                <label for="surname">Repetir contraseña</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="********">
              </div>

            </div> --}}
                        <div class="button-update">
                            <!-- Button trigger modal -->
                            <button type="button" class="btns btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">Modificar</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">¿Desea guardar los cambios?</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- ¿Desea guardar los cambios? --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include('includes.message')
            </div>
        </div>
    </div>
@endsection
