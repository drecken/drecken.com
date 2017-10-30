<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return view('index', compact('user'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('index');
    }
}
