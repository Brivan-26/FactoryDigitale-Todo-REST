<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);
        if($validator->fails()){
            return $this->sendError("Validation of data failed",$validator->errors());
        }
        $user = User::create([
            'email' => $request->email
        ]);
        $token = $user->createToken('todoREST')->plainTextToken;
        // event(new Registered(($user)));
        $result = [
            'user' => new UserResource($user),
            'token' => $token
        ];
        Auth::login($user);
        return $this->sendResponse($result,'Registration was made succesfully!');

    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors());
        }

        $user = User::where('email',$request->email)->first();
        if(!$user) {
            return $this->sendError("No user found with these credentials");
        }
        $token = $user->createToken('todoREST')->plainTextToken;
        $result = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return $this->sendResponse($result, 'Successfully logged in!');
    }

    public function logout(){
        $id=auth('sanctum')->id();
        $user = User::find($id);
        $user->tokens()->delete();

        return $this->sendResponse([],'Logged out succesfully');
    }
}
