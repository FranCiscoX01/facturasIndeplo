<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger("invoice_id");
            $table->foreign('invoice_id')->references('id')->on('invoice');
            
            $table->unsignedBigInteger("section_id");
            $table->foreign('section_id')->references('id')->on('sections');

            $table->integer("quantity");

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
        Schema::dropIfExists('invoice_item');
    }
}
