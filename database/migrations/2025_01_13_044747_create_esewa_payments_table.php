<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsewaPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('esewa_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); 
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('transaction_uuid')->nullable();
            $table->string('ref_id')->nullable();
            $table->float('amount')->default(0)->nullable();  // Allow NULL values
            $table->string('signature')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('esewa_payments');
    }
}
