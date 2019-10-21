<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = ["id", "title","url","node_id","order_list","status_id"];
}
