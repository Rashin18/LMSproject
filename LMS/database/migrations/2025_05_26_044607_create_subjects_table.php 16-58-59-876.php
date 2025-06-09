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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->comment('Subject code like MATH101');
            $table->text('description')->nullable();
            
            // Foreign key to courses table
            $table->foreignId('course_id')
                  ->constrained('courses') // Ensure courses table exists first
                  ->cascadeOnDelete(); // Delete subjects if course is deleted
                  
            // Foreign key to users table (for teacher assignment)
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete(); // Set null if teacher is deleted
                  
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('course_id');
            $table->index('teacher_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};