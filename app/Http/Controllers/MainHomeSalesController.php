<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainHomeSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if (auth()->user()->roles == 'SALES') {
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            //return redirect('/main_home');
            return redirect()->route('home_customer',[$client->client_slug]);
        }
    }
}
