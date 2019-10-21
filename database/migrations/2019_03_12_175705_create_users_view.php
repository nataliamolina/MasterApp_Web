<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace view vusers as 
        select u.id,s.id as stakeholder_id,u.name,u.email,coalesce(u.photo,'') as photo,count(p.id) as services,
        (select count(id) from stakeholder_like where user_id=u.id) as my_like,s.name as description,u.token_google,coalesce(u.phone,'') as phone,
        u.birth_day
        from users u
        left join stakeholders s on s.user_id=u.id
        left join products p on p.supplier_id=s.id
        group by 1,2,3
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW vusers");
    }
}
