@if (session('success'))
    <x-flash-message type="success">
        {{ session('success') }}
    </x-flash-message>
@endif

@if (session('warning'))
    <x-flash-message type="warning">
        {{ session('warning') }}
    </x-flash-message>
@endif

@if ($errors->any())
    <x-validation-errors title="Please review the highlighted fields." />
@endif
