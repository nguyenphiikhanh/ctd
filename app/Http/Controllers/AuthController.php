<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends AppBaseController
{
    //
    public function index(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request){
        try{
            $loginInfo = [
                'username' => $request->username,
                'password' => $request->password,
            ];
            if(Auth::attempt($loginInfo)){
                return redirect()->route('dashboard');
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage().$e->getTraceAsString());
            return back()->with('error','Có lỗi xảy ra');
        }
    }
}
