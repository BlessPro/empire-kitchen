<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechController extends Controller
{
    //

    //written on 12.04.2025
        public function index()
        {

            return view('tech.dashboard'); // Or just return a test string
        }

}
