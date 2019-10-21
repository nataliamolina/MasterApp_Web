<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{
    protected $table = "orders_detail";
    protected $primaryKey = "id";
    protected $fillable = ["id", "product_id","order_id","price","quantity"];

    public function product(){
        return $this->hasOne('App\Models\Administration\Product',"id","product_id");
    }
}
