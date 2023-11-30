<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // fungsi untuk mengembalikan view home
    public function index(Request $request){
        return view('home');
    }
}
