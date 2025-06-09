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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('student_id')->unique();
            $table->foreignId('batch_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });
        
        // Pivot table for student-course relationship
        Schema::create('course_student', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->primary(['course_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
