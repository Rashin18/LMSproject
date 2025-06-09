<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddApplicantToUsersRoleColumn extends Migration
{
    public function up()
    {
        // For ENUM type columns
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'teacher', 'student', 'atc', 'applicant') NOT NULL DEFAULT 'student'");
        
        // OR if using string type
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('role')->default('student')->change();
        // });
    }

    public function down()
    {
        // For reverting - remove applicant from ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'teacher', 'student', 'atc') NOT NULL DEFAULT 'student'");
        
        // OR if using string type
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('role')->default('student')->change();
        // });
    }
}