<?php

namespace App\Services;

use Illuminate\Support\Str;
use Filament\Support\Components\Component;

class ComponentResolver
{
    public function resolve(string $name): string
    {
        if (class_exists($name)) {
            return $name;
        }

        if (Str::contains($name, '::')) {
            return $name;
        }

        $namespaces = [
            'Filament\\Forms\\Components\\',
            'Filament\\Tables\\Components\\',
            'Filament\\Infolists\\Components\\',
        ];

        foreach ($namespaces as $namespace) {
            $class = $namespace . Str::studly($name);
            if (class_exists($class)) {
                return $class;
            }
        }

        return 'filament::' . $name;
    }
}
