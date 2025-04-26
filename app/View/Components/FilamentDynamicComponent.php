<?php

namespace App\View\Components;

use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\View\View;

class FilamentDynamicComponent extends ViewComponent
{
    public function __construct(
        public string $component,
        public array $attributes = []
    ) {}

    protected function renderView(): View
    {
        return view('components.filament.dynamic-component', [
            'component' => $this->component,
            'attributes' => $this->attributes,
        ]);
    }
}
