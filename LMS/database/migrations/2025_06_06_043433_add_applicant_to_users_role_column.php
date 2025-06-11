<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddApplicantToUsersRoleColumn extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('users', 'role')) {
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'teacher', 'student', 'atc', 'applicant') NOT NULL DEFAULT 'student'");
            } else {
                logger()->info("Skipped MODIFY COLUMN for SQLite during applicant role addition.");
            }
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'role')) {
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'teacher', 'student', 'atc') NOT NULL DEFAULT 'student'");
            }
        }
    }
}

