<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('please validate error', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('ahmed')->accessToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'user registerd successfully');
    }


    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('ahmed')->accessToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'user login successfully');

        } else {
            return $this->sendError('please check your auth', ['error'=>'Unauthorised']);
        }


    }

}
