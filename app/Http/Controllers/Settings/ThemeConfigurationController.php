<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ThemeConfigurationController extends Controller
{
    /**
     * Render the Inertia Theme Configuration Page with existing database states.
     */
    public function index()
    {
        $settings = DB::table('settings')
            ->whereIn('key', [
                'base_mode',
                'primary_hue',
                'base_container_bg',
                'header_bg_color',
                'sidebar_bg_color',
                'card_bg_color',
                'heading_color',
                'base_text_color'
            ])
            ->pluck('value', 'key');

        $themeProps = [
            'base_mode'         => $settings->get('base_mode', 'light'),
            'primary_hue'       => $settings->get('primary_hue', '#635bff'),
            'base_container_bg' => $settings->get('base_container_bg', '#f9fafb'),
            'header_bg_color'   => $settings->get('header_bg_color', '#ffffff'),
            'sidebar_bg_color'  => $settings->get('sidebar_bg_color', '#ffffff'),
            'card_bg_color'     => $settings->get('card_bg_color', '#ffffff'),
            'heading_color'     => $settings->get('heading_color', '#111827'),
            'base_text_color'   => $settings->get('base_text_color', '#0b0f19'),
        ];

        return Inertia::render('Settings/Theme', [
            'theme' => $themeProps,
            '_layout' => 'Themed'
        ]);
    }

    /**
     * Persist targeted telemetry parameters to the data layer safely.
     */
    public function update(Request $request)
    {
        $hexRegex = ['required', 'regex:/^#?([A-Fa-f0-9]{6})$/'];

        $validated = $request->validate([
            'base_mode'         => ['required', 'in:light,dark'],
            'primary_hue'       => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'base_container_bg' => $hexRegex,
            'header_bg_color'   => $hexRegex,
            'sidebar_bg_color'  => $hexRegex,
            'card_bg_color'     => $hexRegex,
            'heading_color'     => $hexRegex,
            'base_text_color'   => $hexRegex,
        ]);

        // Normalize color entries safely to protect data layers with leading hex hashes
        foreach ($validated as $key => $value) {
            if ($key !== 'base_mode') {
                $validated[$key] = '#' . ltrim($value, '#');
            }
        }

        DB::transaction(function () use ($validated) {
            foreach ($validated as $key => $value) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updated_at' => now()]
                );
            }
        });

        // Invalidate the cache memory matrix instantly
        ThemeService::clearCache();

        // Pass standard Inertia session status tags back to response pipeline
        return redirect()->back()->with('success', 'Application customization profiles synchronized successfully.');
    }
}
