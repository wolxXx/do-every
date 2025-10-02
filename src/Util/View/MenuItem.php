<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class MenuItem
{
    protected string $target              = '#';

    protected string $name                = '__';

    protected array  $activeRoutes        = [];

    protected string $currentRoute        = '';

    protected string $currentRoutePattern = '';

    public function __toString()
    {
        $isActive = true === in_array(needle: $this->currentRoutePattern, haystack: $this->activeRoutes);
        $class    = 'nav-link menu-button';
        if (true === $isActive) {
            $class .= ' menu-button-active active';
        }

        return <<<HTML
            <li class="nav-item">
                <a href="$this->target" class="{$class}">
                    $this->name
                </a>
            </li>
            HTML;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function setTarget(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getActiveRoutes(): array
    {
        return $this->activeRoutes;
    }

    public function clearActiveRoutes(): static
    {
        $this->activeRoutes = [];

        return $this;
    }

    public function setActiveRoutes(array $activeRoutes): static
    {
        return $this
            ->clearActiveRoutes()
            ->addActiveRoutes(routes: $activeRoutes)
        ;
    }

    public function addActiveRoutes(array $routes): static
    {
        foreach ($routes as $route) {
            $this->addActiveRoute(route: $route);
        }

        return $this;
    }

    public function addActiveRoute(string $route): static
    {
        $this->activeRoutes[] = $route;

        return $this;
    }

    public function getCurrentRoute(): string
    {
        return $this->currentRoute;
    }

    public function setCurrentRoute(string $currentRoute): static
    {
        $this->currentRoute = $currentRoute;

        return $this;
    }

    public function getCurrentRoutePattern(): string
    {
        return $this->currentRoutePattern;
    }

    public function setCurrentRoutePattern(string $currentRoutePattern): static
    {
        $this->currentRoutePattern = $currentRoutePattern;

        return $this;
    }
}
