@props([
    'title',
    'value',
    'icon' => null,
    'trend' => null,
    'trendValue' => null,
    'color' => 'indigo'
])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 transition-all hover:shadow-md']) }}>
    <div class="flex justify-between">
        <div>
            <div class="text-gray-500 text-sm font-medium">{{ $title }}</div>
            <div class="mt-2 text-2xl font-bold text-{{ $color }}-600">{{ $value }}</div>

            @if($trend)
                <div class="mt-2 flex items-center text-sm">
                    @if($trend === 'up')
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="ml-1 text-green-600">{{ $trendValue }}</span>
                    @else
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                        <span class="ml-1 text-red-600">{{ $trendValue }}</span>
                    @endif
                </div>
            @endif
        </div>

        @if($icon)
            <div class="text-{{ $color }}-500">
                {{ $icon }}
            </div>
        @endif
    </div>

    @if($slot->isNotEmpty())
        <div class="mt-4 text-sm text-gray-600">
            {{ $slot }}
        </div>
    @endif
</div>
