<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('merchant_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id'); // ID merchant/restoran
            $table->unsignedBigInteger('subscription_plan_id');
            $table->date('start_date'); // Tanggal mulai berlangganan
            $table->date('end_date'); // Tanggal berakhir berlangganan
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->string('payment_status')->default('pending'); // Status pembayaran
            $table->string('transaction_id')->nullable(); // ID transaksi pembayaran
            $table->decimal('paid_amount', 10, 2); // Jumlah yang dibayarkan
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('subscription_plan_id')
                  ->references('id')
                  ->on('subscription_plans')
                  ->onDelete('cascade');
            
            // Anda bisa menambahkan foreign key untuk merchant jika sudah memiliki tabel merchants
            $table->foreign('merchant_id')
                  ->references('id')
                  ->on('merchants')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('merchant_subscriptions');
    }
};
