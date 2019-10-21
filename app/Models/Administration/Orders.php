<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    protected $primaryKey = "id";
    protected $fillable = ["id", "date_service","restriction_alimentary","client_id","status_id","user_id","address","reason"];


    public function user(){
        return $this->hasOne('App\User',"id","client_id");
    }
    public function detail(){
        return $this->hasMany(OrdersDetail::class,"order_id","id");
    }
}
