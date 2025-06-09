<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('teacher_id'); // sender
        $table->unsignedBigInteger('student_id'); // receiver
        $table->string('subject');
        $table->text('body');
        $table->timestamps();

        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
