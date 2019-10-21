<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Order;
use DB;

class OrdersController extends Controller
{
    public function index(){

        $orders = DB::table("vorders")->get();
        //dd($orders);
        return view("orders.index",\compact("orders"));
    }
}
