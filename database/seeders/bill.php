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
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->string('agreement_id');
            $table->string('shop_id');
            $table->string('tenant_id');
            $table->decimal('rent', 10, 2);
            $table->string('tenant_full_name');
            $table->string('shop_address');
            $table->date('bill_date');
            $table->date('due_date');
            $table->string('status');
            $table->decimal('penalty', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->date('discount_date');
            $table->unsignedSmallInteger('month')->default(now()->month);
            $table->unsignedSmallInteger('year')->default(now()->year);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('agreement_id')->references('agreement_id')->on('agreements')->onDelete('cascade');
            // $table->foreign('shop_id')->references('id')->on('shop_rents')->onDelete('cascade');
            // $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
