<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = "card";
    protected $primaryKey = "id";
    protected $fillable = ["id", "number_card","titular"];
    
}
