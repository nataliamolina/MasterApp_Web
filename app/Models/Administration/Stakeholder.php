<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $table = "stakeholders";
    protected $primaryKey = "id";
    protected $fillable = ["id", "name","document","description","address","phone","type_stakeholder_id","url_image","url_qr","user_id"];

    protected $casts = [
        'type_stakeholder_id' => 'array',
    ];

    public function user(){
        return $this->hasOne('App\User',"id","user_id");
    }
}
