<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_subscription_id');
            $table->string('payment_gateway'); // Misal 'midtrans', 'xendit', dll
            $table->string('external_payment_id')->nullable(); // ID pembayaran dari gateway
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->json('payment_details')->nullable(); // Detail tambahan dari gateway
            $table->timestamps();

            $table->foreign('merchant_subscription_id')
                  ->references('id')
                  ->on('merchant_subscriptions')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_payments');
    }
};
