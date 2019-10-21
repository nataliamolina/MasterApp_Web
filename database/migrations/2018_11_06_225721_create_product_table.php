<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    
    
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->text("description");
            $table->decimal('price', 15, 2);
            $table->text("url_image");
            $table->string("slug");
            $table->integer("subcategory_id");
            $table->integer("supplier_id")->unsigned();
            $table->foreign('supplier_id')->references('id')->on('stakeholders');
            $table->integer("status_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
