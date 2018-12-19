<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Flicktrack';
        return view('pages.index')->with('title', $title);
    }

    public function tvshows(){
        $title = "TV Shows";
        return view('pages.tvshows')->with('title', $title);
    }

    public function movies(){
        $title = "Movies";
        return view('pages.movies')->with('title', $title);
    }



}
