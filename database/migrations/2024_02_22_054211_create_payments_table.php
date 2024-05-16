<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->string('tenant_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('previous_balance', 10, 2)->default(0.0);
            $table->date('payment_date');
            $table->string('payment_method');
            $table->string('status')->default('success');
            $table->text('remark')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('transaction_number')->references('transaction_number')->on('transactions')->onDelete('cascade');
            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
