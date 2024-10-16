<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('username')->unique();
            //$table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('picture')->nullable();
            $table->string('password');
            $table->timestamp('license_validity')->nullable();
            $table->float('cash_balance',7,2)->default(0);
            $table->integer('credits')->default(0);

            $table->string('sessionToken')->unique();
            $table->string('api_secret');
            $table->string('api_public');
            $table->enum('status',['verified','not-verified','suspended']);

            $table->enum('role',['admin','client','reseller'])->default('client');

            $table->rememberToken();
            $table->timestamps();

            $table->index('id');
            $table->index('sessionToken');
            $table->index('api_secret');
            $table->index('api_public');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
