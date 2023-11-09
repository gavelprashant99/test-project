<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $language = $request->input('language');
        if (in_array($language, ['en', 'hi'])) {
            Session::put('locale', $language);
        }
    
        return response()->json(['message' => 'Language changed successfully']);
    }
}
