<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\StakeholderLike;
use Illuminate\Support\Facades\Validator;
use App\User;
use DB;
use Intervention\Image\ImageManager;
// use App\Models\Administration\Categories;

class StakeholderController extends Controller
{
    public function index(){
        $stakeholder["results"]=DB::table("vstakeholder")->where("user_id","<>",auth()->user()->id)->get();
        return response()->json($stakeholder);
    }
    public function store(Request $req){
        $in = $req->all();
        $in["user_id"] = auth()->user()->id;
        $in["type_stakeholder_id"] = array(1);
        
        $valida = Validator::make($in, [
            'document' => 'required|max:20|unique:stakeholders'
        ]);

        if($valida->fails()){
            return response()->json($valida->errors(),400);
        }


        $stake = Stakeholder::create($in);
        
        return response()->json(["status"=>"created","data"=>$stake]);
    }

    public function edit($id){
        $stakeholder["results"] = DB::table("vstakeholder")->where("id",$id)->first();
        $like=null;
        if(auth()->user()->stakeholder != null){
            $like = StakeholderLike::where("stakeholder_id",$id)->where("user_id",auth()->user()->stakeholder->user_id)->first();
        }
        
        $stakeholder["user_like"] = ($like==null)?false:true;
        return response()->json($stakeholder);
    }

    public function editAll($id){
        $cat = \App\Models\Administration\Category::where("slug",$id)->first();
        $stakeholder["results"] = DB::table("vstakeholder")
        ->select("id","photo",DB::raw("INITCAP(name) as name"),"slug")->where("subcategory_id",$cat->id)
        ->where("user_id","<>",auth()->user()->id)->get();
        return response()->json($stakeholder);
    }

    public function updatePhoto(Request $req){
        $in=$req->all();
        if(isset($in["image"])){
            $user=User::find(auth()->user()->id);
            
            $image = $in["image"];
            unset($in["image"]);
            $id = uniqid();
            $path_photo=public_path()."/images/stakeholder/$id.png";
            $path_db="images/stakeholder/$id.png";

            $user->photo=$path_db;
            $manager = new ImageManager(array('driver' => 'imagick'));
            $image = $manager->make(base64_decode($image))->widen(400);
            $image->save($path_photo);
            $user->save();
        }
        
        return response()->json($user);
    }

    public function likeStakeholder(Request $req,$id){
        $in = $req->all();
        
        $like = StakeholderLike::where("user_id",auth()->user()->id)->where("stakeholder_id",$id)->first();

        if($like==null){
            $new["user_id"] = auth()->user()->id;
            $new["stakeholder_id"] = $id;
            StakeholderLike::create($new);
            $resp=["status"=>"ok","msg"=>"like"];
        }else{
            $like->delete();
            $resp=["status"=>"ok","msg"=>"dislike"];
        }

        return response()->json($resp);
    }

    public function editDescription(Request $req){
        $in=$req->all();
        $user = auth()->user();
        $user->stakeholder->name = $in["name"];
        $user->stakeholder->description = $in["description"];
        $user->stakeholder->save();
        return response()->json($user);
    }

    public function update(){
        dd("asdasd");
    }
}


