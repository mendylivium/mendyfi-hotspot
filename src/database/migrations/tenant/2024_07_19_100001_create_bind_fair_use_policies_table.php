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
        Schema::create('bind_fair_use_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fair_user_policy_id');
            $table->unsignedBigInteger('hotspot_profile_id');

            $table->foreign('fair_user_policy_id')->references('id')->on('fair_use_policies')->onDelete('cascade');
            $table->foreign('hotspot_profile_id')->references('id')->on('hotspot_profiles')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bind_fair_use_policies');
    }
};
