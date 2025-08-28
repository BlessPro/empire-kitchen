<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //

    public function index() {
        return view('admin.Employee');
    }

    public function addemployee() {
        return view('admin.addemployee');
    }
}
