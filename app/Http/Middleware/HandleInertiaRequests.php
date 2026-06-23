<?php

namespace App\Http\Middleware;

use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = App::getLocale();

        return array_merge(parent::share($request), [
            'locale' => $locale,
            'translations' => function () use ($locale) {
                $phpTranslations = collect(File::glob(lang_path("$locale/*.php")))
                    ->mapWithKeys(function ($path) {
                        return [basename($path, '.php') => File::getRequire($path)];
                    })->toArray();
                $jsonPath = lang_path("$locale.json");
                $jsonTranslations = File::exists($jsonPath) ? json_decode(File::get($jsonPath), true) : [];

                return array_merge($phpTranslations, $jsonTranslations);
            },
            'auth' => [
                'user' => $request->user()
                    ? $request->user()->only('id', 'name', 'email') + ['roles' => $request->user()->roles()->select('id', 'name', 'display_name')->get()]
                    : null,
            ],
            'menuGroups' => config('navigation.sidebar'),
            'themeMetrics' => fn () => ThemeService::getThemeMetrics(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
