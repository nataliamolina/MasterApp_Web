<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Auth;
use DB;
use App\Http\Controllers\Api\Auth\IssueTokenTrait;


class LoginController extends Controller
{

    use IssueTokenTrait;


    public function login(Request $request){
        $this->validate($request,[
            "username"=>'required',
            "password"=>'required',
        ]);

        return $this->issueToken($request,"password");
        
    }

    public function refresh(Request $request){
        $this->validate($request,[
            "refresh_token"=>'required',
        ]);

       return $this->issueToken($request,"refresh_token");
    }

    public function logout(Request $request){
        $accessToken = Auth::user()->token();

        
        $re = DB::table("oauth_refresh_tokens")
            ->where("access_token_id",$accessToken->id)->update(["revoked"=>true]);
        
        $accessToken->revoke();

        return response()->json([],204);

    }

   
}
