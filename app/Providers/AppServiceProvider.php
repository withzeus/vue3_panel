<?php

namespace App\Providers;

use App\Interfaces\Repository\RoleRInterface;
use App\Interfaces\Repository\UserRInterface;
use App\Models\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Services\ThemeService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRInterface::class, UserRepository::class);
        $this->app->bind(RoleRInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            '*',
            fn ($view) => $view->with(
                'theme',
                ThemeService::getThemeMetrics()
            )
        );
        Gate::before(function (User $user, string $ability) {
            $hasDenyRecord = $user->permissions()
                ->where('name', 'deny:'.$ability)
                ->exists();

            if ($hasDenyRecord) {
                return false; 
            }
        });

        Gate::after(function (User $user, string $ability, $result) {
            if ($result === null || ! $result) {
                return $user->hasPermission($ability);
            }

            return $result;
        });
    }
}
