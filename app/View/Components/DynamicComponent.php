<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class DynamicComponent extends Component
{
    public function __construct(
        public string $component,
        public array $attributes = []
    ) {}

    public function render()
    {
        $prefix = 'filament::';

        if (Str::startsWith($this->component, $prefix)) {
            return view('components.filament-dynamic', [
                'component' => $this->component,
                'attributes' => $this->attributes,
            ]);
        }

        return view($this->component, $this->attributes);
    }
}
