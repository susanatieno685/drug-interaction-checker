@props([
    'type' => 'success',
    'dismissible' => true,
])

@php
    $alertClass = match ($type) {
        'warning' => 'alert-warning',
        'danger' => 'alert-danger',
        'info' => 'alert-info',
        default => 'alert-success',
    };
@endphp

<div {{ $attributes->merge(['class' => trim('alert ' . $alertClass . ($dismissible ? ' alert-dismissible fade show' : ''))]) }} role="alert">
    {{ $slot }}

    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
