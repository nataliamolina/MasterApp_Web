<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\IssueTokenTrait;

class RegisterController extends Controller
{

    use IssueTokenTrait;


    public function register(Request $request){
        $this->validate($request,[
            "name"=>"required",
            "email"=>"required|email|unique:users",
            "password"=>"required|min:6",
        ]);

        $user = \App\User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
        ]);

        return $this->issueToken($request,"password");

    }
}
