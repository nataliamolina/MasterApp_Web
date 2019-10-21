<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakeholdersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create or replace view vstakeholder as
        select s.id,s.name,s.address,s.phone,u.photo,s.user_id,count(p.id) as services,
        (select count(id) from stakeholder_like where stakeholder_id=s.id) as follower,s.subcategory_id,cat.slug 
        from stakeholders s
        join users u on u.id=s.user_id
        left join products p on p.supplier_id=s.id
        join categories as cat on cat.id=s.subcategory_id
        group by 1,2,3,4,5,cat.slug");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW vstakeholder");
    }
}
