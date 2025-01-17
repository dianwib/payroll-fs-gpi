<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //
    public function switch($locale)
    {
        // Check if the locale exists in the supported locales
        if (array_key_exists($locale, config('app.locales'))) {
            session()->put('locale', $locale);
            app()->setLocale($locale);
        }

        return redirect()->route('filament.pages.dashboard');
    }
}
