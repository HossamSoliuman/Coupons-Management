<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('mainPage');
        $role = auth()->user()->role;
        if ($role == 'admin') {
            return redirect()->route('admin.index');
        } else if ($role == 'user')
            return view('mainPage');
        // return redirect()->route('code.get_offer');
    }
    public function admin()
    {
        $role = auth()->user()->role;
        if ($role == 'admin') {
            return redirect()->route('admin.index');
        }
    }
}
