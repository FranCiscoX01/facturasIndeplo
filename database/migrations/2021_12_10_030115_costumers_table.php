<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CostumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costumers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name", 20);
            $table->string("company_name", 60);

            $table->unsignedBigInteger("status_id");
            $table->foreign('status_id')->references('id')->on('status');

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
        Schema::dropIfExists('costumers');
    }
}
