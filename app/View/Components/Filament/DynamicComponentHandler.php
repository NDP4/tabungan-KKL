<?php

namespace App\View\Components\Filament;

use Illuminate\View\Component;
use Filament\Support\Facades\FilamentView;

class DynamicComponentHandler extends Component
{
    public function __construct(
        public string $component,
    ) {}

    public function render()
    {
        return FilamentView::make($this->component)
            ->with(['attributes' => $this->attributes]);
    }
}
