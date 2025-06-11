<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAtcRoleToUsersTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('users', 'role')) {
            if (env('DB_CONNECTION') === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','student', 'teacher', 'admin', 'atc') DEFAULT 'student'");
            } else {
                // SQLite does not support MODIFY COLUMN or ENUM types
                // Skip or log for manual handling
                logger()->info("Skipped ALTER COLUMN for 'role' in SQLite");
            }
        }
    }

    public function down()
    {
        if (env('DB_CONNECTION') === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','student', 'teacher', 'admin') DEFAULT 'student'");
        }
    }
}

