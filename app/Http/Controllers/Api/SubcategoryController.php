<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Category;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    public function index(){
        $cat["results"]=[
            ["id"=>1,"url"=>"images/category/categorias_cocina.png","title"=>"chef"],
            ["id"=>2,"url"=>"images/category/categorias_belleza.png","title"=>"bartender"],
            ["id"=>3,"url"=>"images/category/categorias_mascotas.png","title"=>"mesero"],
        ];

        return response()->json($cat);
    }

    public function edit($id){
        $cat = Category::where("slug",$id)->first();
        
        $arr = Category::select("id",DB::raw("upper(title) as title"),"url","slug")->where("node_id",$cat->id)->get();
        //dd($arr);

        // if($id==1){
        //     Category::
        //     $arr = [
        //         ["id"=>1,"url"=>"images/category/categorias_cocina.png","title"=>"chef"],
        //         ["id"=>2,"url"=>"images/category/categorias_belleza.png","title"=>"bartender"],
        //         ["id"=>3,"url"=>"images/category/categorias_mascotas.png","title"=>"mesero"],
        //     ];
        // }else if($id==2){
        //     $arr = [
        //         ["id"=>4,"url"=>"images/category/categorias_cocina.png","title"=>"Jardin"],
        //         ["id"=>5,"url"=>"images/category/categorias_belleza.png","title"=>"Domador"],
        //     ];
        // }else if($id==3){

        //     $arr = [
        //         ["id"=>6,"url"=>"images/category/categorias_cocina.png","title"=>"Peluqueros"],
        //         ["id"=>7,"url"=>"images/category/categorias_belleza.png","title"=>"Masajistas"],
        //     ];
        // }

        $result["results"] = $arr;
        return response()->json($result);
    }

    public function getFilter($slug){
        $cat = Category::where("slug",$slug)->first();
        //dd($cat);
        $list = Category::where("node_id",$cat->id)->get();
        $result["results"] = $list;
        return response()->json($result);
    }
}
