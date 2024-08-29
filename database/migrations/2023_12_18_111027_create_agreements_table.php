<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_id')->unique();
            $table->string('shop_id');
            $table->string('tenant_id');
            $table->date('with_effect_from');
            $table->date('valid_till');
            $table->integer('rent');
            $table->string('status');
            $table->text('remark')->nullable();
            $table->string('document_field')->nullable();
            $table->timestamps();
            $table->integer('user_id');
            // Indexing shop_id and tenant_id for better performance
            $table->index('shop_id');
            $table->index('tenant_id');
        });
    }


    public function down()
    {
        Schema::dropIfExists('agreements');
    }
}
