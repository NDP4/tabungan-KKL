<?php

namespace App\View\Components\Filament;

interface ComponentInterface
{
    public function getView(): string;
    public function getData(): array;
}
