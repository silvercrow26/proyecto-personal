
@if(auth::user()->image)
    <img class="card-img-top avatar" src="{{ route('user.avatar',['fileName'=>auth::user()->image]) }}" alt="Card image cap">
@endif