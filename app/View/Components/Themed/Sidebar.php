<?php

namespace App\View\Components\Themed;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public object $theme;
    public array $menuGroups;

    /**
     * Create a new component instance.
     */
    public function __construct(object $theme)
    {
        $this->theme = $theme;
        $this->menuGroups = config('navigation.sidebar', []);
    }

    /**
     * Check if a specific menu item is currently active.
     */
    public function isActive(array $item): bool
    {
        $pattern = $item['active_pattern'] ?? '';
        
        if (is_array($pattern)) {
            return request()->is($pattern);
        }

        return request()->is($pattern);
    }

    /**
     * Safely resolve the link URL from route names or standard paths.
     */
    public function getUrl(array $item): string
    {
        if (isset($item['route'])) {
            return route($item['route']);
        }
        
        return url($item['url'] ?? '#');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.themed.sidebar');
    }
}