<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $fillable = ["id", "title","description","user_id","stakeholder_id","product_id","qualification","url_image"];
}
