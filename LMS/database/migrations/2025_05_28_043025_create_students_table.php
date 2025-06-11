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
          if (!Schema::hasTable('students')) {
             Schema::create('students', function (Blueprint $table) {
               $table->id();
               $table->string('name');
               $table->string('email');
               $table->string('student_id');
               $table->foreignId('batch_id')->constrained()->onDelete('cascade');
               $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
               $table->timestamps();
           });
        }
        
        // Pivot table for student-course relationship
        if (!Schema::hasTable('course_student')) {
        Schema::create('course_student', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->primary(['course_id', 'student_id']);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
