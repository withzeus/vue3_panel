<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RoutePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $routes = Route::getRoutes();

        $excludedPrefixes = ['_debugbar', '_ignition', 'sanctum', 'horizon', 'telescope', 'storage'];
        $excludedNames = ['login', 'logout', 'password.', 'verification.', 'boost'];

        foreach ($routes as $route) {
            $name = $route->getName();
            $uri = $route->uri();

            if (! $name || Str::contains($name, $excludedNames) || Str::startsWith($uri, $excludedPrefixes)) {
                continue;
            }

            // Standardize format: e.g., 'users.index' becomes 'users-index' or remains 'users.index'
            // Laratrust reads names directly. Let's make human-readable display names too.
            $displayName = Str::of($name)
                ->replace('.', ' ')
                ->replace('-', ' ')
                ->title();

            Permission::firstOrCreate(
                ['name' => $name],
                [
                    'display_name' => $displayName.' Access',
                    'description' => "Allows execution across endpoint: [{$uri}]",
                ]
            );
        }
    }
}
