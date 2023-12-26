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
            $table->decimal('rent', 10, 2);
            $table->date('payment_date');
            $table->date('due_date');
            $table->string('status');
            $table->decimal('penalty', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->unsignedSmallInteger('month')->default(now()->month);
            $table->unsignedSmallInteger('year')->default(now()->year);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('agreement_id')->references('agreement_id')->on('agreements')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
