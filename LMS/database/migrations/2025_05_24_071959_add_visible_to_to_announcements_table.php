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
    Schema::table('announcements', function (Blueprint $table) {
        $table->enum('visible_to', ['all', 'teachers', 'students', 'admins'])
              ->default('all')
              ->after('is_active');
    });
}

public function down()
{
    Schema::table('announcements', function (Blueprint $table) {
        $table->dropColumn('visible_to');
    });
}
};
