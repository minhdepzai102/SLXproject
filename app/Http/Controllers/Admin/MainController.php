<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Simply return the view for authenticated users
        return view('admin.main', ['title' => 'Main Page']);
    }
}

