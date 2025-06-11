<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class accountantReportsController extends Controller
{
    //
    public function index()
    {
        return view('accountant.Reports&Analytics');
    }
}
