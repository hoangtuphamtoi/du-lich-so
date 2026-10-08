<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function switch(Request $r)
    {
        $data = $r->validate(['theme' => 'required|in:sang,toi']);
        
        return back()->withCookie(
            cookie(
                'theme', 
                $data['theme'], 
                minutes: 60 * 24 * 365,
                path: '/', 
                domain: null, 
                secure: app()->isProduction(),
                httpOnly: false, 
                sameSite: 'lax'
            )
        );
    }
}