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
        Schema::create('unified_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->float('price',10,2);
            $table->bigInteger('uptime_limit')->nullable();
            $table->bigInteger('data_limit')->nullable();
            $table->bigInteger('max_download')->nullable();
            $table->bigInteger('max_upload')->nullable();
            $table->bigInteger('validity')->nullable();
            $table->timestamps();

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unified_profiles');
    }
};
