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
        Schema::create('resellers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->string('picture')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();;
            $table->string('acces_token')->nullable();
            $table->string('address_name')->nullable();
            $table->string('map_longitude')->nullable();
            $table->string('map_latitude')->nullable();
            $table->enum('status',['active','suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resellers');
    }
};
