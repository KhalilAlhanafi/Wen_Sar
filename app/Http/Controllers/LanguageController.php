<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        $availableLocales = ['ar', 'en'];
        
        if (!in_array($locale, $availableLocales)) {
            abort(400);
        }
        
        Session::put('locale', $locale);
        
        return redirect()->back();
    }
}
