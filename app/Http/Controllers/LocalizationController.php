<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LocalizationController extends Controller
{
    /**
     * Set the application locale and redirect back to the previous page.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocale(Request $request)
    {
        $locale = $request->locale;
        App::setLocale($locale);

        // return $locale;
        // Check if the selected locale is supported
        if (in_array($locale, ['en', 'ar'])) {
            // Set the application locale
            App::setLocale($locale);
            App::setLocale($locale);
            // return App::getLocale();
            // Store the selected locale in the session
            session()->put('locale', $locale);
        }

        // Redirect back to the previous page
        return Redirect::back();
    }
}
