<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    
    public function graphicsDesign()
    {
        return view('categories.graphics-design');
    }
    
    public function programmingTech()
    {
        return view('categories.programming-tech');
    }
    
    public function digitalMarketing()
    {
        return view('categories.digital-marketing');
    }
    
    public function videoAnimation()
    {
        return view('categories.video-animation');
    }
    
    public function writingTranslation()
    {
        return view('categories.writing-translation');
    }
    
    public function musicAudio()
    {
        return view('categories.music-audio');
    }
    
    public function business()
    {
        return view('categories.business');
    }
    public function show()
    {
        return view('categories.show');
    }
}