<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        // Pivot table for course-student many-to-many relationship
        Schema::create('course_student', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->primary(['course_id', 'student_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    
    }
};