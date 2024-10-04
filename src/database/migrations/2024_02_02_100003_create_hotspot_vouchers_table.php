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
        Schema::create('hotspot_vouchers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->string('code');
            $table->string('password')->nullable();
            $table->unsignedBigInteger('hotspot_profile_id');
            $table->string('mac_address')->nullable();
            $table->string('session_id')->nullable();
            $table->boolean('connected')->default(false);
            $table->bigInteger('uptime_credit')->nullable();
            $table->bigInteger('data_credit')->nullable();
            $table->bigInteger('total_used_time')->default(0);
            $table->bigInteger('total_used_data')->default(0);
            $table->bigInteger('fup_used_time')->default(0);
            $table->bigInteger('fup_used_data')->default(0);
            // $table->boolean('has_uptime_limit')->default(false);
            // $table->boolean('has_data_limit')->default(false);
            $table->string('server_name')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('router_ip')->nullable();
            $table->string('router_name')->nullable();
            $table->timestamp('generation_date')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->timestamp('used_date')->nullable();
            $table->timestamp('interim')->nullable();
            $table->bigInteger('recent_data_use')->nullable();
            $table->bigInteger('recent_time_use')->nullable();
            $table->bigInteger('session_upload')->nullable();
            $table->bigInteger('session_download')->nullable();
            $table->boolean('sales_recorded')->default(false);
            $table->enum('login_type',['voucher','cashless'])->default('voucher');
            $table->string('batch_code')->nullable();
            $table->boolean('unified')->default(false);
            $table->timestamps();

            $table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
            $table->foreign('hotspot_profile_id')->references('id')->on('hotspot_profiles')->onDelete('cascade');

            $table->index('id');
            $table->index('user_id');
            $table->index('code');
            $table->index('reseller_id');
            $table->index('hotspot_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspot_vouchers');
    }
};
