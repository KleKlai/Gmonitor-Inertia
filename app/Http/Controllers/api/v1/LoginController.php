<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'email'     => 'required|email',
            'password'  => 'required'
        ));

        if($validator->fails()) {
            return response(['message' => $validator->errors()]);
        }

        # code...
        $login = $request->validate([
            'email'     => ['required', 'string'],
            'password'  => ['required', 'string'],
        ]);


        //If Fail
        if(!Auth::attempt($login)) {
            return response(['message' => 'Invalid login credentials']);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => Auth::user(), 'access_token' => $accessToken]);
    }

    // Not WORKING
    public function logout(Request $request)
    {

        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


}
