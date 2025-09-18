<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GatemanController extends Controller
{
    public function index()
    {
        return view('gateman.index');
    }
}
