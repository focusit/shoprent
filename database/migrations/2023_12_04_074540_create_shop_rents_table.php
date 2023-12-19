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
        Schema::create('shop_rents', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->unique();
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('pincode');
            $table->string('status');
            $table->decimal('rent', 8, 2);
            $table->string('tenant_id')->nullable(); // Add this line
            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('set null'); 
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_rents');
    }
};
