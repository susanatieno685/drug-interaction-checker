@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }} role="alert">
        @if (isset($title) && $title !== null)
            <strong>{{ $title }}</strong>
        @endif

        <ul class="mb-0 {{ isset($title) && $title !== null ? 'mt-2' : '' }}">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
