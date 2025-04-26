@props([
    'value' => 0,
    'max' => 100,
    'label' => '',
    'color' => 'indigo'
])

@php
$percentage = min(($value / $max) * 100, 100);
@endphp

<div {{ $attributes->merge(['class' => 'relative pt-1']) }}>
    @if($label)
        <div class="flex mb-2 items-center justify-between">
            <div>
                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-{{ $color }}-600 bg-{{ $color }}-200">
                    {{ $label }}
                </span>
            </div>
            <div class="text-right">
                <span class="text-xs font-semibold inline-block text-{{ $color }}-600">
                    {{ number_format($percentage, 1) }}%
                </span>
            </div>
        </div>
    @endif

    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-{{ $color }}-200">
        <div style="width:{{ $percentage }}%"
             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-{{ $color }}-500 transition-all duration-500">
        </div>
    </div>
</div>
