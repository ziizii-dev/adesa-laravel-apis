<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Register page
    public function register(Request $request){
        // return $request;
        $this->userRegisterValidationCheck($request);
   $user = ([
        "name"=>$request->name,
        "email"=>$request->email,
        "password"=>Hash::make($request->password)
    ]);
    return $user;
    $data = User::create($user);
    return response()->json([
            "error"=>false,
            "message"=>"Registration Success.",
            "data"=>$data
        ]);

    }//End method

    //For login page
    public function login(Request $request){
        if(!Auth::attempt($request->only("email","password"))){
            return [
                "message"=>"invalid"
            ];
        }
       $user = Auth::user();
    //    return $user;

    $token = $user->createToken('token')->plainTextToken;
    //   return $token;
    $cookie = cookie("jwt",$token, 60*24);
    return response([
        "message"=>"success",
        "token"=>$token

    ])->withCookie($cookie);
    }//End method
    //For user detail
    public function user(){
        $user = Auth::user()->get();
        return $user;
        return response()->json([
            "error"=>false,
            "message"=>"Registration Success.",
            "data"=>$user,

        ]);

      }//End method

      //For Logout Page
      public function logout(){
        $cookie = Cookie::forget('jwt');
        return response()->json([
            "message"=>"success"
        ])->withCookie($cookie);
      }//End method

    private function userRegisterValidationCheck($request){
        Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',

        ])->Validate();
    }//End method
}
