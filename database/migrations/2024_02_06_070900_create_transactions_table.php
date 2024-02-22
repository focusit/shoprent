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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->date('transaction_date');
            $table->string('property_type');
            $table->string('tenant_name');
            $table->string('type');
            $table->unsignedSmallInteger('month')->default(now()->month);
            $table->unsignedSmallInteger('year')->default(now()->year);
            $table->string('payment_method')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
