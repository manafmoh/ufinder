<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthfacebookController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['facebooklogin']]);
    }

    public function login(Request $request)
    {
        if (! $request) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $prevResult = User::firstOrNew(['provider_id'=>$request->id, 'provider'=> 'facebook']);
        if($prevResult) {
            $prevResult->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->provider = 'facebook';
            $user->provider_id = $request->id;
            $user->password = 'abc123';
            $user->save();
        }
        return $this->doLogin($request->email, $request->name);
    }
    public function doLogin($email, $name)
    {

        $credentials = ["email"=>$email, "password"=>"abc123"];
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->name
        ]);
    }
}
