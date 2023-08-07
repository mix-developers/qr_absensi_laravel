<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];
        $data = [
            'title' => 'Dashboard',
            'widget' => $widget,
        ];

        return view('pages.home', $data);
    }
    public function profile()
    {
        $data = [
            'title' => 'Profile',
        ];

        return view('pages.akun.index', $data);
    }
}
