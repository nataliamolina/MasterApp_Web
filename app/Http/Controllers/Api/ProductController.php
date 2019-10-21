<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Product;
use Intervention\Image\ImageManager;

use DB;

class ProductController extends Controller
{
    public function index(){
        $product["results"]=Product::all();
        return response()->json($product);
    }
    public function store(Request $req){
        $in = $req->all();

        if(auth()->user()->stakeholder == null){
            return response()->json(["status"=>false,"msg"=>"Aún no eres proveedor"]);
        }

        $in["url_image"]='';
        
        if(isset($in["image"])){
            $image = $in["image"];
            unset($in["image"]);
            $id = uniqid();
            $path_photo=public_path()."/images/products/$id.png";
            $path_db="images/products/$id.png";

            $manager = new ImageManager(array('driver' => 'imagick'));
            $image = $manager->make(base64_decode($image))->widen(400);
            $image->save($path_photo);
            $in["url_image"] = $path_db;
        }
                
        $in["supplier_id"] = auth()->user()->stakeholder->id;
        $in["status_id"] = auth()->user()->id;
        $product = Product::create($in);
        return response()->json(["status"=>"created","data"=> $product]);
    }

    public function update(Request $request,$id){
        $in = $request->all();
        $pro = Product::find($id);
        $pro->fill($in)->save();
        return response()->json(["status"=>"edited","data"=> $pro]);
    }

    public function getPhotos(){
        $list = Product::all();
        return response()->json(["status"=>"created","data"=> $list]);
    }

    public function getPhotosStakeholder($supplier_id){
        $list["results"] = DB::table("vproducts")->where("supplier_id",$supplier_id)->get();
        return response()->json($list);
    }

    public function getProductStakeholder($supplier_id,$slug){
        $cat = \App\Models\Administration\Category::where("slug",$slug)->first();
        $product["results"] = DB::table("vproducts")->where("supplier_id",$supplier_id)->where("subcategory_id",$cat->id)->get();
        return response()->json($product);
    }

    public function getProductStakeholderAll(){

        $product["results"] = DB::table("vproducts")->where("supplier_id",auth()->user()->stakeholder->id)->get();
        return response()->json($product);
    }
}
    