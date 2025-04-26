<?php

namespace App\View\Components\Filament;

use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\View\View;

class BaseComponent extends ViewComponent implements ComponentInterface
{
    protected string $viewName = 'filament::components.dynamic-component';

    protected array $viewData = [];

    public function getView(): string
    {
        return $this->viewName;
    }

    public function getData(): array
    {
        return $this->viewData;
    }

    protected function renderView(): View
    {
        return view($this->getView(), $this->getData());
    }
}
