<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Product extends Model
{
    use Sluggable,
    SluggableScopeHelpers;

    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable = ["id", "title","description","price","supplier_id","insert_id","subcategory_id","url_image","status_id"];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function supplier(){
        return $this->hasOne('App\Models\Administration\Stakeholder',"id","supplier_id");
    }
}
