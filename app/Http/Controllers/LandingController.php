<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        
        $beritas = collect();
        $laporans = collect();

        return view('welcome', compact('beritas', 'laporans'));
    }

    public function showBerita($slug)
    {
        return "Detail berita: " . $slug;
    }
}