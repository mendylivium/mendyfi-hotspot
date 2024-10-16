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
        Schema::create('active_fair_use_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('bind_fair_use_policy_id');
            $table->enum('type', ['hotspot', 'pppoe'])->default('hotspot');
            $table->timeStamp('resets_on');
            $table->timestamps();

            $table->foreign('bind_fair_use_policy_id')->references('id')->on('bind_fair_use_policies')->onDelete('cascade');
        
            $table->index('id');
            $table->index('client_id');
            $table->index('bind_fair_use_policy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_fair_use_policies');
    }
};
