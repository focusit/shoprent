<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_id');
            $table->string('shop_id');
            $table->string('tenant_id');
            $table->integer('rent');
            $table->string('tenant_full_name');
            $table->string('shop_address');
            $table->date('bill_date');
            $table->date('due_date');
            $table->date('discount_date');
            $table->string('status');
            $table->integer('user_id');
            $table->integer('penalty');
            $table->integer('discount');
            $table->integer('tax');
            $table->integer('prevbal');
            $table->integer('total_bal');
            $table->unsignedSmallInteger('month')->default(now()->month);
            $table->unsignedSmallInteger('year')->default(now()->year);
            $table->string('transaction_number');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('transaction_number')->references('transaction_number')->on('transactions')->onDelete('cascade');
            $table->foreign('agreement_id')->references('agreement_id')->on('agreements')->onDelete('cascade');
            e('cascade');
            // $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
