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
        Schema::create('hotspot_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->string('name');
            $table->string('description');
            $table->float('price',10,2);
            $table->bigInteger('uptime_limit')->nullable();
            $table->bigInteger('data_limit')->nullable();
            $table->bigInteger('max_download')->nullable();
            $table->bigInteger('max_upload')->nullable();
            $table->bigInteger('validity')->nullable();
            $table->bigInteger('total_uptime')->nullable();
            $table->bigInteger('total_data')->nullable();
            $table->timestamps();

            $table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');

            $table->index('id');
            $table->index('user_id');
            $table->index('reseller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspot_profiles');
    }
};
