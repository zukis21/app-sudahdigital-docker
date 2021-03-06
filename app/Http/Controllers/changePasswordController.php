<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
class changePasswordController extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            if($client->client_slug == $param){
                if(session()->get('client_sess')== null){
                    \Request::session()->put('client_sess',
                    ['client_name' => $client->client_name,'client_image' => $client->client_image]);
                }
                if(Gate::allows('change-password')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor){
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return view('users.change_password',['vendor'=>$vendor,'client'=>$client]);
    }

    public function changepassword(Request $request, $vendor){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }
             
            if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            }
            if(!(strcmp($request->get('new-password'), $request->get('new-password-confirm'))) == 0){
                        //New password and confirm password are not same
                        return redirect()->back()->with("error","New Password should be same as your confirmed password. Please retype new password.");
            }
            //Change Password
            $user = Auth::user();
            $user->password = \Hash::make($request->get('password'));
            $user->save();
             
            return redirect()->back()->with("status","Password changed successfully !");
    }
}
