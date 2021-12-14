<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("code", 30);

            $table->unsignedBigInteger("order_id");
            $table->foreign('order_id')->references('id')->on('orders');

            $table->string("file")->nullable();

            $table->date("date");

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
        Schema::dropIfExists('invoice');
    }
}
