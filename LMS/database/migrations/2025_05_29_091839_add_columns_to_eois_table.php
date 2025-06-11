<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEoisTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('eois', 'user_id')) {
            Schema::table('eois', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('eois', 'user_id')) {
            Schema::table('eois', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
    }
}

