@props(['component'])

@php
    $componentClass = "\\Filament\\Forms\\Components\\" . str_replace('/', '\\', $component);
@endphp

<x-filament-dynamic :component="$componentClass" {{ $attributes }} />
