<div class="card pub_image">
    <!--Imagen, metodo users del modelo imagen y su nombre-->
    <div class="card-header">
        @if ($image->users->image)
            @include('includes.image')
        @endif

        <div class="data-user">
            <a>
                {{ $image->users->name . ' ' . $image->users->surname }}
                <span class="nickname">{{ ' | @' . $image->users->nick }} </span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <!--Metodo para buscar la imagen en el Storage dentro de ImageController-->
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
            <img src="{{ asset('icons/hearts-red.png') }}" data-id="{{ $image->id }}" class="btn-like" />
        @else
            <img src="{{ asset('icons/hearts-gray.png') }}" data-id="{{ $image->id }}" class="btn-dislike" />
        @endif
        <span class="nickname">{{ count($image->likes) }}</span>
    </div>

    <div class="description">
        <span class="nickname">{{ '@' . $image->users->nick }} </span>
        <span class="nickname">{{ ' | ' . \FormatTime::LongTimeFilter($image->created_at) }}</span>
        <p>{{ $image->description }}</p>
    </div>
    <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-warnning btn-comments">
        Comentarios ({{ count($image->comments) }})
        <!--Numero de comentarios de la imagen-->
    </a>
</div>
