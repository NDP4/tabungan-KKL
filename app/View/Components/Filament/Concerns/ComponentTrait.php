<?php

namespace App\View\Components\Filament\Concerns;

trait ComponentTrait
{
    protected array $componentData = [];

    public function withData(array $data): static
    {
        $this->componentData = array_merge($this->componentData, $data);
        return $this;
    }

    public function getData(): array
    {
        return array_merge(
            $this->componentData,
            ['attributes' => $this->attributes]
        );
    }
}
