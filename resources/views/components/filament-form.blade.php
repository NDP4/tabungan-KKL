@php
    $component = $attributes->get('component');
    $attribs = $attributes->except('component');
@endphp

<x-filament::dynamic-component
    :component="$component"
    :attributes="$attribs"
/>
