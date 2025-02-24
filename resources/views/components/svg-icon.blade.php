@php
    $path = resource_path("svg/{$icon}.svg");
@endphp

@if (file_exists($path))
    {!! file_get_contents($path) !!}
@else
    <!-- Fallback or error -->
    <span>Icon not found</span>
@endif
