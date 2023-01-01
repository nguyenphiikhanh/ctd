<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends AppBaseController
{
    //
    public function login(Request $request){
        try{
            $loginInfo = [
                'username' => $request->username,
                'password' => $request->password,
            ];
            if(Auth::attempt($loginInfo)){
                return redirect()->
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage().$e->getTraceAsString());
            return $this->sendError('Có lỗi xảy ra',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
