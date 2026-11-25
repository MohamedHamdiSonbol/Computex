<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class LanguageController extends Controller
{
    public function __invoke($lang)
    {
        // 1. Check if the language is supported (optional but recommended)
        $supportedLocales = ['en', 'ar', 'fr'];

        if (in_array($lang, $supportedLocales)) {
            // 2. Save the language choice in the session
            Session::put('locale', $lang);
            App::setLocale($lang);
        }

        // 3. Send them back to the page they were on
        return redirect()->back();
    }
}
