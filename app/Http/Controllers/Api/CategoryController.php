<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Category;

class CategoryController extends Controller
{
    public function index(){

        $cat["results"] = Category::where("node_id",0)->orderBy("order_list","desc")->get();

        // $cat["results"] = [
        //     ["id"=>1,"url"=>"images/category/categorias_cocina.png","title"=>"cocina"],
        //     ["id"=>2,"url"=>"images/category/categorias_belleza.png","title"=>"belleza"],
        //     ["id"=>3,"url"=>"images/category/categorias_mascotas.png","title"=>"mascotas"],
        //     ["id"=>3,"url"=>"images/category/categorias_hogar.png","title"=>"hogar"],
        // ];

        return response()->json($cat);
    }

    public function store(Request $req){
        $in = $req->all();
        $row = Category::create($in);
        return response()->json(["status"=>true,"row"=>$row]);
    }

    public function getCategoryTitle($title){
        $cat = Category::where("title",$title)->first();
        $detail["results"] = Category::where("node_id",$cat->id)->get();
        return response()->json($detail);
    }
}
