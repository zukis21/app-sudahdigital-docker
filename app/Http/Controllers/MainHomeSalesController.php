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
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $loged_in = \Carbon\Carbon::now();
            $log_time = $loged_in->toDateTimeString();
            //dd($log_time);
            $log_record = \App\LoginRecord::whereYear('logged_in',$year)
                        ->whereMonth('logged_in',$month)
                        ->whereDay('logged_in',$day)
                        ->where('user_id',auth()->user()->id)
                        ->where('client_id',auth()->user()->client_id)->first();
            if(!$log_record) {
                $log_record = new \App\LoginRecord();
                $log_record->client_id = $client->id;
                $log_record->user_id = \Auth::user()->id;
                $log_record->logged_in = $log_time;
                $log_record->save();
            }
            return redirect()->route('home_customer',[$client->client_slug]);
        }
    }
}
