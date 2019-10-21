<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class StakeholderLike extends Model
{
    protected $table = "stakeholder_like";
    protected $primaryKey = "id";
    protected $fillable = ["id", "stakeholder_id","user_id"];
}
