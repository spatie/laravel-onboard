<?php

namespace Spatie\Onboard;

use Illuminate\Support\Arr;
use Spatie\Onboard\Concerns\Onboardable;

class OnboardingStep
{
    protected array $attributes = [];

    /** @var callable|null */
    protected $excludeIf;

    /** @var callable|null */
    protected $completeIf;

    protected ?Onboardable $model;

    public function __construct(string $title)
    {
        $this->attributes(['title' => $title]);
    }

    public function cta(string $cta): self
    {
        $this->attributes(['cta' => $cta]);

        return $this;
    }

    public function link(string $link): self
    {
        $this->attributes(['link' => $link]);

        return $this;
    }

    public function excludeIf(callable $callback): self
    {
        $this->excludeIf = $callback;

        return $this;
    }

    public function completeIf(callable $callback): self
    {
        $this->completeIf = $callback;

        return $this;
    }

    public function setModel(Onboardable $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function excluded(): bool
    {
        if ($this->excludeIf && $this->model) {
            return once(fn () => app()->call($this->excludeIf, ['model' => $this->model]));
        }

        return false;
    }

    public function notExcluded(): bool
    {
        return ! $this->excluded();
    }

    public function complete(): bool
    {
        if ($this->completeIf && $this->model) {
            return once(fn () => app()->call($this->completeIf, ['model' => $this->model]));
        }

        return false;
    }

    public function incomplete(): bool
    {
        return ! $this->complete();
    }

    public function attribute(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->attributes, $key, $default);
    }

    public function attributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function __get(string $key): mixed
    {
        return $this->attribute($key);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }
}
