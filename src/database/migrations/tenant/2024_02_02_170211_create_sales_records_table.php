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
        Schema::create('sales_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('reseller_id');            
            $table->float('amount',7,2);
            $table->string('code');
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('router_ip')->nullable();
            $table->string('server_name')->nullable();
            $table->string('router_name')->nullable();
            $table->string('profile_name')->nullable();
            $table->enum('account_type',['hotspot','pppoe']);
            $table->timeStamp('transact_date')->currentTimeStamp();
            $table->timestamps();

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
        Schema::dropIfExists('sales_records');
    }
};
