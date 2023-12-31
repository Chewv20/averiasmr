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
    /* public function index(Request $request)
    {
        $request->session()->put(['Prueba'=>'Valor de prueba']);
        $request->session()->put(['Prueba2'=>'Valor de prueba2']);

        return $request->session()->all();
    } */

    


}
