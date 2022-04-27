<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * register function
     *
     * @param Request $request
     *  @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required'],
            'email'     => ['required', 'unique:users,email', 'email'],
            'password'  => ['required'],
            'role'      => ['required',Rule::in(User::USER_ROLES)]
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors(), 'Validation Error', 400);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role
        ]);
        $data['token'] =  $user->createToken('auth_token')->plainTextToken;
        $data['name']  =  $user->name;
        $data['email'] =  $user->email;
        return $this->handleResponse($data, ' registered!');
    }

    /**
     * login function
     *
     * @param Request $request
     *  @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('auth_token')->plainTextToken;
            $success['name']  =  $auth->name;
            return $this->handleResponse($success, 'User successfully logged-in');
        }
        else{
            return $this->handleError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        return $this->handleResponse(Auth::user()->tokens()->delete(), 'User successfully logged-out');
    }
}
