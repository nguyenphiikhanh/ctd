<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        try{

        }
        catch(\Exception $e){
            Log::error($e->getMessage().$e->getTraceAsString());
            return
        }
    }
}
