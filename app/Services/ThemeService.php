<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ThemeService
{
    private const CACHE_KEY = 'global_application_theme_metrics';

    /**
     * Fetch global theme rules safely from memory cache with strict key isolation.
     */
    public static function getThemeMetrics(): object
    {
        return (object) Cache::rememberForever(self::CACHE_KEY, function () {
            $settings = DB::table('settings')->pluck('value', 'key');   

            return [
                'base_mode' => $settings['base_mode'],
                'primary_hue' => $settings['primary_hue'] ?? '#635bff',

                'base_container_bg' => $settings['base_container_bg'],
                'base_text_color' => $settings['base_text_color'],

                'header_bg_color' => $settings['header_bg_color'],
                'sidebar_bg_color' => $settings['sidebar_bg_color'],
                'heading_color' => $settings['heading_color'],
                'card_bg_color' => $settings['card_bg_color'],

                'dark_header_bg_color' => '#1f2937',
                'dark_sidebar_bg_color' => '#111827',
                'dark_heading_color' => '#9ca3af',
            ];
        });
    }

    /**
     * Invalidate old theme cache states instantly.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
