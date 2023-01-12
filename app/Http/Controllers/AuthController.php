<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends AppBaseController
{
    public function index(){
        return view('login');
    }
    //
    public function login(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if(! auth()->attempt($requestData)){
            return $this->sendError(__('auth.failed'),Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return $this->sendResponse(['user' => auth()->user(), 'access_token' => $accessToken],__('auth.success'));
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->sendResponse($user,__('message.success.show',['atribute' => 'logged user']));
    }

    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
