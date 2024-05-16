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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->unique()->cascade('cascade');
            $table->string('govt_id')->nullable();
            $table->string('image');
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('full_name');
            $table->string('govt_id_number')->unique()->nullable();
            $table->string('contact', 15)->nullable();
            $table->string('password')->nullable();
            $table->string('gst_number')->default('pending');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
