<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Product;
use DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(){
        dd(Storage::disk('s3')->allFiles("pet"));
        $orders = Product::where("supplier_id",auth()->user()->stakeholder->id)->get();
        
        return view("products.index",\compact("orders"));
    }
}
