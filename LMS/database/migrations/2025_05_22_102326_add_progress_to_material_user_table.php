<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgressToMaterialUserTable extends Migration
{
    public function up()
    {
        Schema::table('material_user', function (Blueprint $table) {
            $table->boolean('is_watched')->default(false);
            $table->unsignedInteger('progress')->default(0);
        });
    }

    public function down()
    {
        Schema::table('material_user', function (Blueprint $table) {
            $table->dropColumn(['is_watched', 'progress']);
        });
    }
}
