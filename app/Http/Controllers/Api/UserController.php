<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\User;
use Log;
use Intervention\Image\ImageManager;
use DB;

class UserController extends Controller
{
    public function index(){
        $user = DB::table("vusers")->where("id",auth()->user()->id)->first();
        return response()->json($user);
    }

    public function updatePhoto(Request $req){
        $in = $req->all();    
        Log::debug($in);
        $image=$in["image"];
        unset($in["image"]);
        $id = auth()->user()->id;
        $path_photo=public_path()."/images/profiles/$id.png";
        $path_db="images/profiles/$id.png";

        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = $manager->make(base64_decode($image))->widen(400);
        $image->save($path_photo);
        
        $user = User::find(auth()->user()->id);
        $user->photo = $path_db;
        $user->save();
        
        return response()->json(["status"=>"created","user"=>$user],202);
        
    }

    public function refreshToken(Request $req){
        $in = $req->all(); 
        $user = User::find(auth()->user()->id);
        $user->token_google = $in["token_google"];
        $user->save();
        return response()->json(["status"=>"created","user"=>$user],202);
    }

    public function updateName(Request $req,$id){
        $in = $req->all();
        
        if($in["name"]!=''){
            $user = User::find(auth()->user()->id);
            $user->name = $in["name"];
            $user->save();
            return response()->json(["status"=>"edited","user"=>$user],202);
        }else{
            return response()->json(["status"=>"wrong","msg"=>"Texto Vacio"],409);
        }
    }

    public function update(Request $req){
        $in = $req->all();
        unset($in["email"]);
        $user = User::find(auth()->user()->id);
        $user->fill($in)->save();
        return response()->json($user,202);
    }
}
