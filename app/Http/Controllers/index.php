<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class index extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return "Selamat Datang";
    }

}
