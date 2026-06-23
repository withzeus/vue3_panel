<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Update the global application session locale target.
     */
    public function update(Request $request)
    {
        $request->validate([
            'locale' => ['required', 'string', 'in:en,mm'], // Protect against unsupported locales
        ]);

        // Save the chosen language directly into Laravel's session pool
        $request->session()->put('locale', $request->input('locale'));

        return back();
    }
}