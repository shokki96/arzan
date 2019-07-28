<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        //dd(\auth('api'));
        //return response()->json(['success' => \auth()->guard('api')], 200);
        if(auth()->attempt(['phone' => request('phone'), 'password' => request('password')])){
            $user = auth()->user();
            $success['user'] =  $user;
            $success['token'] =  $user->createToken('riyeltorski')->accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }


    public function userRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Abonent::create($input);
        $success['token'] =  $user->createToken('riyeltorski')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], 200);
    }


    public function userDetails()
    {
//        $users = User::get();
        return response()->json(['success' => \auth()->user()], 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
