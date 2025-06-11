<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtcRoleToUsersTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('users', 'role')) {
            // If you're using MySQL, use raw statement (conditionally)
            if (env('DB_CONNECTION') === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','student', 'teacher', 'admin', 'atc') DEFAULT 'student'");
            } else {
                // SQLite workaround: SQLite does not support MODIFY
                // You may have to create a new table and copy data if strict change is required
                // Or skip this change in SQLite
                logger('Skipping role enum change on SQLite due to lack of support.');
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

