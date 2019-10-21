<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Orders;
use App\Models\Administration\VOrders;
use App\Models\Administration\OrdersDetail;
use App\Models\Administration\Product;
use App\Traits\ToolTrait;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;

class OrderController extends Controller
{
    use ToolTrait;

    public function index(){
        $res["results"] = DB::table("vorders")->where("client_id",auth()->user()->id)->orderBy("created_at","desc")->get();
        return response()->json($res);
    }


    public function orderSupplier(){
        $res["results"] = DB::table("vorders")->where("supplier_id",auth()->user()->stakeholder->id)->get();
        return response()->json($res);
    }

    public function store(Request $req){
        $in = $req->all();

        \Log::debug($in);

                $date = DateTime::createFromFormat('Y/m/d H:i', $in["date_service"]);
        $in["date_service"] = $date->format('Y-m-d H:i');
        $in["client_id"] = auth()->user()->id;
        $in["status_id"] = 1;
        $in["restriction_alimentary"] = ($in["restriction_alimentary"]==null)?'':$in["restriction_alimentary"];
        
        $order_id = Orders::create($in)->id;
        $products = json_decode($in["products"]);
        
        Log::debug($products);
        unset($in["products"]);
        unset($in["product_id"]);
        foreach($products as $pro){
            Log::debug($pro);
            
            if(is_array($pro)){
                echo "si";
                $row = $pro;
            }else{
                $row = json_decode($pro, true);
            }

            
            

            $pro = Product::find($row["product_id"]);
            if($pro!=null){
                $row["order_id"] = $order_id;
                $row["price"] = $pro->price;
                OrdersDetail::create($row);
            }else{
                return response()->json(["status"=>true,"messsage"=>"Producto no encontrado"],402);

            }

        }

        $order = Orders::find($order_id);


        $notification = [
                     'title' => 'Solicitud de Servicio',
                     'body' => auth()->user()->name." tiene una petición para ".$in["date_service"],
        ];
        
        $recipients=[$pro->supplier->user->token_google];

        $data = [
               'order_id' => $order->id,
               "date_service"=>$order->date_service,
               "restriction_alimentary" => $in["restriction_alimentary"],
               "address" => $in["address"],
               
        ];

        Log::debug($data);

        $this->sendPush($recipients,$notification,$data);
        return response()->json(["status"=>true,"data"=>$order]);
    }

    public function update(Request $req, $order_id){
        $in = $req->all();
        Log::debug($order_id);
        Log::debug($in);

        $order = Orders::find($order_id);
        
        $msg="";
        //$token_google = $order->product->supplier->user->token_google;
        
        $token_google = $order->user->token_google;
        
        
        if($in["accept"] == "true"){
            $order->status_id = 2;
            $msg= "Confirmacion de Servicio";
            $body = $order->detail->first()->product->supplier->name. " ha confirmado la Order #".$order->id;
            
        }else{
            $msg= "Cancelación de Servicio";
            $order->status_id = 3;
            $order->reason = $in["reason"];
            $body="La Order #".$order->id." ha sido cancelada por el proveedor ".$in["reason"];
        }

        $order->save();   

        $notification=[
            'title' => $msg,
            'body' => $body,
        ];

        //$recipients=[$order->user->token_google];
        $recipients=[$token_google];
        Log::debug($recipients);
        Log::debug($notification);
        $data = (array)DB::table("vorders")->where("id",$order_id)->first();
        
        $this->sendPush($recipients,$notification,$data);


        return response()->json(["status"=>true,"data"=>$order]);
    }

    public function payment($order_id){
        $order = Orders::find($order_id);
        $order->status_id = 3;
        $order->save();
        return response()->json(["status"=>true]);
    }

    public function getOrderDetail($order_id){
        $res["results"] = DB::table("vorders_detail")->where("order_id",$order_id)->get()->toArray();
        return response()->json($res);
    }
   
}
