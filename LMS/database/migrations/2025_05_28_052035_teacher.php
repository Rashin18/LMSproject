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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('teacher_id')->unique();
            $table->foreignId('department_id')->constrained();
            $table->string('qualification');
            $table->string('specialization')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('joining_date');
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->text('bio')->nullable();
            $table->timestamps();
        });
        
        // Teacher-Batch pivot table
        Schema::create('batch_teacher', function (Blueprint $table) {
            $table->foreignId('batch_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
            $table->boolean('is_lead_teacher')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
