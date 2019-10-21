<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\IssueTokenTrait;
use Laravel\Passport\Client;
use App\User;
use DB;
use Illuminate\Validation\Rule;

class SocialAuthController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct(){
        $this->client=Client::find(1);
    }

    public function socialAuth(Request $request){
        $this->validate($request,[
            "name"=>'required',
            "email"=>'required',
            "provider"=>'required|in:facebook,twitter,google',
            "provider_user_id"=>'required'
        ]);

        $socialAccount= \App\SocialAccount::where("provider",$request->provider)
            ->where("provider_user_id",$request->provider_user_id)
            ->first();

        if($socialAccount){
            return $this->issueToken($request,'social');
        }

        $user = User::where("email",$request->email)->first();

        if($user){
            $this->addSocialAccountNetwork($request,$user);
        }else{
            try{
                $this->createUserAccount($request);
            }catch(\Exception $e){
                return response("An error ocurred, please retry later", 422);
            }
        }

        return $this->issueToken($request,'social');
    }

    private function addSocialAccountNetwork(Request $request, User $user){
        $this->validate($request,[
            "provider"=>["required",Rule::unique("social_accounts")->where(function($query) use($user){
                return $query->where("user_id",$user->id);
            })],
            "provider_user_id"=>'required'
        ]);
        
        $socialAccount = new \App\SocialAccount([
            "provider"=>$request->provider,
            "provider_user_id"=>$request->provider_user_id
        ]);

        $user->socialAccount()->create([
                    "provider"=>$request->provider,
                    "provider_user_id"=>$request->provider_user_id
                ]);
    }

    private function createUserAccount(Request $request){
        DB::transaction(function() use($request){
            $photo = (isset($request->photo))?$request->photo:'';
            $user = User::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "photo"=>$photo
            ]);

            $this->addSocialAccountNetwork($request,$user);
        });
    }
}
