<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->enum('mode', ['cod', 'bank', 'wallet']);
            $table->enum('wallet_mode', ['khalti', 'e-sewa', 'nepalpay', 'namstepay'])->nullable();
            $table->enum('status', ['pending', 'approved', 'declined', 'refunded'])->default('pending');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
