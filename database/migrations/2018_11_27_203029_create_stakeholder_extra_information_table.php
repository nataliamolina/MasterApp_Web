<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakeholderExtraInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stakeholder_extra_information', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('business');
            $table->date('date_init');
            $table->date('date_end')->nullable();
            $table->boolean('finished')->default(false);
            $table->integer("stakeholder_id")->unsigned();
            $table->integer("type_information_id");
            $table->foreign("stakeholder_id")->references("id")->on("stakeholders");
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
        Schema::dropIfExists('stakeholder_extra_information');
    }
}
