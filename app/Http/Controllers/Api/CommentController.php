<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Comment;
use Intervention\Image\ImageManager;
use DB;
class CommentController extends Controller
{
    public function index(){
        $comment["results"]= DB::table("vcomment")->orderBy("created_at","desc")->get();
        return response()->json($comment);
    }

    public function store(Request $req){
        $in = $req->all();

        $in["url_image"]="";

        if(isset($in["image"])){
            $image = $in["image"];
            unset($in["image"]);

            $id = uniqid();
            $path_photo=public_path()."/images/comments/$id.png";
            $path_db="images/comments/$id.png";
            
            $manager = new ImageManager(array('driver' => 'imagick'));
            $image = $manager->make(base64_decode($image))->widen(400);
            $image->save($path_photo);
            $in["url_image"] = $path_db;
        }
        
        
        $in["user_id"] = auth()->user()->id;
        $resp = Comment::create($in);

        return response()->json($resp);
    }

    public function getCommentStakeholder($supplier_id){
        $product["results"] = DB::table("vcomment")->where("stakeholder_id",$supplier_id)->get();
        return response()->json($product);
    }
}
