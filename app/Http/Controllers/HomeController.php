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
        if ((auth()->user()->roles == 'SUPERADMIN') || (auth()->user()->roles == 'ADMIN') || (auth()->user()->roles == 'SUPERVISOR')) {
            //return view('home');
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            if(session()->get('client_sess')== null){
                \Request::session()->put('client_sess',
                ['client_name' => $client->client_name,'client_image' => $client->client_image]);
            }
            $cek_stts_stock =  \DB::table('product_stock_status')
            ->where('product_stock_status.client_id','=',auth()->user()->client_id)
            ->count();
            //dd($cek_stts_stock);
            if($cek_stts_stock < 1){
                $stock_status =[
                    [
                    'status_name' => 'Product Stock-'.$client->client_name,
                    'client_id' => $client->id,
                    ]
                ]; 
                
                \DB::table('product_stock_status')->insert($stock_status);
            }
            return redirect()->route('home_admin',[$client->client_slug]);
            
        }else if (auth()->user()->roles == 'SALES') {
            return redirect('/main_home');
        }
        //return view('home');
    }

}
