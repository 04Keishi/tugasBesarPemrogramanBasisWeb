<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        // Jika sudah login, langsung ke dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('landing');
    }
}
