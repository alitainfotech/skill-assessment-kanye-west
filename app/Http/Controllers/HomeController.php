<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return view('home');
    }
    
    public function show()
    {
        $quotes = (new kanyeController)->get_quote();
        $quotes = json_encode($quotes);

        return Inertia::render('Pages/Quotes', [
            'data' => $quotes
        ]);
    }


}
