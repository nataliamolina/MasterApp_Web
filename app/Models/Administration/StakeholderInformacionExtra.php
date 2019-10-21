<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class StakeholderInformacionExtra extends Model
{
    protected $table = "stakeholder_extra_information";
    protected $primaryKey = "id";
    protected $fillable = ["id", "title","description","business","date_init","date_end","finished","stakeholder_id","type_information_id"];
}