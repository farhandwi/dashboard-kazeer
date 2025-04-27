<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pemilik/restoran
            $table->string('business_name'); // Nama bisnis/restoran
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('logo')->nullable(); // Path logo merchant
            $table->text('description')->nullable(); // Deskripsi restoran
            $table->string('website')->nullable();
            $table->json('social_media')->nullable(); // Akun media sosial
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('merchants');
    }
};
