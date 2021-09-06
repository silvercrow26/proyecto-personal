
{{-- Mensaje de alerta --}}

@if (session('message'))
    <div class="alerta">
        <div class="alert alert-success alerta" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    </div>
@endif
