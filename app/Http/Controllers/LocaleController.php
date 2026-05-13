<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $allowed = ['en', 'fa'];
        $locale = in_array($locale, $allowed) ? $locale : config('app.locale', 'en');

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
