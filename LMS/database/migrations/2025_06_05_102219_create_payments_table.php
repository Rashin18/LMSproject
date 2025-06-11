<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('order_id');
                $table->string('payment_id')->nullable();
                $table->decimal('amount', 10, 2);
                $table->string('currency')->default('INR');
                $table->string('status');
                $table->text('metadata')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
