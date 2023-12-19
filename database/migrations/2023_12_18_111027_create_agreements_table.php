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
            $table->string('agreement_id');
            $table->string('shop_id');
            $table->string('tenant_id');
            $table->date('with_effect_from');
            $table->date('valid_till');
            $table->decimal('rent', 10, 2);
            $table->enum('status', ['active', 'inactive']);
            $table->text('remark')->nullable();
            $table->string('document_field');
            $table->timestamps();

            // Foreign keys
            $table->foreign('shop_id')->references('id')->on('shop_rents');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agreements');
    }
}
