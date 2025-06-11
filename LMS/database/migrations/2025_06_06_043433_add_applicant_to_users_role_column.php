<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddApplicantToUsersRoleColumn extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('users', 'role')) {
            if (env('DB_CONNECTION') === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'teacher', 'student', 'atc', 'applicant') NOT NULL DEFAULT 'student'");
            } else {
                // SQLite fallback: Log info
                logger()->info("Skipped ENUM MODIFY on SQLite for users.role");
            }
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'role') && env('DB_CONNECTION') === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'teacher', 'student', 'atc') NOT NULL DEFAULT 'student'");
        }
    }
}
