@props(['component'])

<x-filament::dynamic-component
    :component="$component"
    {{ $attributes->class([
        'fi-form-component',
        'fi-contained' => config('filament.layout.forms.have_inline_labels', false),
    ]) }}
/>
