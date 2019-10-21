<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->text("url_image");
            $table->integer('qualification')->defaul(0);
            $table->integer('stakeholder_id')->unsigned();
            $table->foreign("stakeholder_id")->references("id")->on("stakeholders");
            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign("product_id")->references("id")->on("products");
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
        Schema::dropIfExists('comments');
    }
}
