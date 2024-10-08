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
            $table->integer('bill_no');
            $table->string('transaction_number')->unique();
            $table->date('transaction_date');
            $table->string('agreemnet_id');
            $table->string('shop_id');
            $table->string('tenant_id');
            $table->string('tenant_name');
            $table->integer('amount')->default(0);
            $table->string('type');
            $table->string('payment_method')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('reconciled_by');
            $table->string('G8');
            $table->integer('user_id');
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
