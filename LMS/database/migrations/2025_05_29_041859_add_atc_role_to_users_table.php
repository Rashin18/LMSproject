<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAtcRoleToUsersTable extends Migration
{
    public function up()
    {
        $connection = Schema::getConnection()->getDriverName();

        if (Schema::hasColumn('users', 'role')) {
            if ($connection === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','student','teacher','admin','atc') DEFAULT 'student'");
            } else {
                // Skip for SQLite or log message
                logger()->info("Skipped role column modification: incompatible with driver [$connection]");
            }
        }
    }

    public function down()
    {
        $connection = Schema::getConnection()->getDriverName();

        if ($connection === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','student','teacher','admin') DEFAULT 'student'");
        }
    }
}

