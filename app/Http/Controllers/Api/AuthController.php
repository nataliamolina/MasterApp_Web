<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\User;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Log;

use \App\Client as ClientToken;

class AuthController extends Controller
{
    public $client;

    public function __construct(){
        $this->client = ClientToken::find(1);
    }

    public function register(Request $req){
        $in=$req->all();

        $validatorData=$req->validate([
                "email"=>"required|unique:users",
                "name"=>"required",
                "phone"=>"required|unique:users"
                ]);

        $user = new \App\User();
        $user->name = $in["name"];
        $user->email = $in["email"];
        $user->phone = (isset($in["phone"])?$in["phone"]:'');
        $user->token_google = (isset($in["token_google"])) ? $in["token_google"] : null;

        $http = new Client;

        if(isset($in["provider"]) && $in["provider"]=='GOOGLE'){
            $response = $http->post(url("oauth/token"),[
                "form_params"=>[
                    "grant_type"=>"client_credentials",
                    "client_id"=>"1",
                    "client_secret" => "PrguDhMfBqgoM6Q5Hj4MxgR6DG1ybYE0xxqa1WiB",
                    
                ]
            ]);
        }

        $user->password=bcrypt($in["password"]);
        $user->save();

        if(isset($in["image"])){
            $image=$in["image"];

            $id = $user->id;
            $path_photo=public_path()."/images/profiles/$id.png";
            $path_db="images/profiles/$id.png";

            $manager = new ImageManager(array('driver' => 'imagick'));
            $image = $manager->make(base64_decode($image))->widen(400);
            $image->save($path_photo);

            $user = User::find($user->id);
            $user->photo = $path_db;
            $user->save();
        }
       
        $response = $http->post(url("oauth/token"),[
            "form_params"=>[
                "grant_type"=>"password",
                "client_id"=>$this->client->id,
                "client_secret"=>$this->client->secret,
                "username"=>$in["email"],
                "password"=>$in["password"],
                "scope"=>''
            ]
        ]);

        return response(["data"=>json_decode((string)$response->getBody(),true)]);

    }

    public function findOrCreateUser(){
        
    }

    public function login(Request $req){
        $in=$req->all();
        Log::debug("ingreso login");
        Log::debug($in);
        $validatorData=$req->validate([
            "email"=>"required",
            "password"=>"required",
            ]);

        $user = \App\User::where("email",$in["email"])->first();

        if(!$user){
            return response()->json(["status"=>"error","message"=>"User not found"],202);
        }

        Log::debug(Hash::check($in["password"],$user->password));

        //if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

        if(Hash::check(trim($in["password"]),$user->password)){
            Log::debug("validado");
            $http = new Client;
            $response = $http->post(url("oauth/token"),[
                "form_params"=>[
                    "grant_type"=>"password",
                    "client_id"=>$this->client->id,
                    "client_secret"=>$this->client->secret,
                    "username"=>$in["email"],
                    "password"=>$in["password"],
                    "scope"=>''
                ]
            ]);

            Log::debug((string)$response->getBody());

            return response(["data"=>json_decode((string)$response->getBody(),true),"status"=>true]);
        }else{
            return response()->json(["status"=>"error","message"=>"Wrong password"],202);
        }

    }
}
