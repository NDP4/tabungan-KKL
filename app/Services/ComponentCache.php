<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\Repository;

class ComponentCache
{
    protected Repository $cache;
    protected string $prefix = 'filament_component_';

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function remember(string $key, callable $callback): mixed
    {
        if (!config('components.cache_components')) {
            return $callback();
        }

        return $this->cache->remember(
            $this->prefix . $key,
            now()->addHour(),
            $callback
        );
    }

    public function forget(string $key): bool
    {
        return $this->cache->forget($this->prefix . $key);
    }

    public function flush(): bool
    {
        return $this->cache->tags([$this->prefix])->flush();
    }
}
