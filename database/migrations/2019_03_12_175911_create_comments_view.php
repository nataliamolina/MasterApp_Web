<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create view vcomment as
        select c.id,c.title,c.description,c.url_image,c.user_id,s.name as user,p.title as product,p.slug,c.created_at,c.product_id,c.stakeholder_id
        from comments c
        JOIN users s ON s.id=c.user_id
        left JOIN products p ON p.id=c.product_id
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW vcomment");
    }
}
